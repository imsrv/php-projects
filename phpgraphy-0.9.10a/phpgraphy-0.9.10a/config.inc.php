<?php
/*
*  Copyright (C) 2004-2005 JiM / aEGIS (jim@aegis-corp.org)
*  Copyright (C) 2000-2001 Christophe Thibault
*
*  This program is free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2, or (at your option)
*  any later version.
*
*  This program is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License
*  along with this program; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
*
*  $Id: config.inc.php 129 2005-07-02 22:24:18Z jim $
*
*/

// phpGraphy configuration file


/***
* directive: admin_ip
* type: string
* description: Your IP address, it need to be provided during the installation procedure
*   so that nobody else is able to create an administrator account on your behalf.
*   If you don't know what your IP address is don't worry it will be given to you 
*   during the installation procedure.
* example: "193.29.43.244", "192.168.0.1", "127.0.0.1"
***/
$admin_ip="";


/*****
*
* Directories location
*
*****/


/***
* directive: root_dir
* type: string
* description: Path to your pictures (with trailing '/').
* example: "pictures/" or "/home/http/htdocs/pictures/" or "../pictures/")
***/
$root_dir="pictures/";

/***
* directive: data_dir
* type: string
* description:	Path to your data files (with trailing '/'). This directory is used
*		with the fast text database and some exif functions).
* example: "data/" or "../data/"
***/
$data_dir="data/";

/***
* directive: icons_dir
* type: string
* description:	Path to phpgraphy icons (with trailing '/'),
* 		default should be fine in most cases.
***/
$icons_dir="graphics/";





/*****
*
* Thumbnails/Lowres pictures generation related
*
*****/


/***
* directive: thumb_generator
* type: string
* description: Choose a thumbnail/lowresolution generator between
* 	"convert" - if you have ImageMagick installed and accessible from php,
* 	"gd" - if you have GD support with PHP (now bundled by default),
* 	"manual" - if you want to make thumbnails and low res images yourself,
* 	"auto" - autodetecting first available mode in the above listed order.
***/
$thumb_generator="auto";

/***
* directive: convert_path
* type: string
* description:	If you use convert as $thumb_generator, you can specify its path
* 		using this directive (leave blank for auto detection).
* example: "/usr/bin/convert"
***/
// $convert_path="/usr/bin/convert";

/***
* directive: thumb_res
* type: string
* description:	Size (in pixels) of the generated thumbnails
***/
$thumb_res="100x100";

/***
* directive: thumb_quality
* type: int
* description: Quality (from 10 to 100) of the generated thumbnails
***/
$thumb_quality=60;

/***
* directive: lr_limit
* type: string
* description:	Size (in bytes) where we generate a low resolution picture
*		Basically, if the picture is bigger than this size, a low resolution
*		picture will be generated.
* example: "1024*100" mean that if a picture is more than 100KBytes, we generate a low res.
***/
$lr_limit=1024*100;

/***
* directive: lr_res
* type: string
* description: Size (in pixels) of the generated low resolution pictures.
***/
$lr_res="800x600";

/***
* directive: lr_quality
* type: int
* description: Quality (from 10 to 100) of the generated low resolution pictures.
***/
$lr_quality=80;

/***
* directive: rotate_tool
* type: string
* from_version: 0.9.10
* description: Choose your favorite image rotation tool 
* 	"exiftran" - Best choice, lossless rotation from the first release
* 	"jpegtran" - Perhaps the most famous, was not handling the metadata until recently
* 	"manual" - If you don't want/can't use any tool (do it yourself)
* 	"auto" - autodetecting first available mode in the above listed order.
***/
$rotate_tool="auto";

/***
* directive: rotate_tool_path
* type: string
* from_version: 0.9.10
* description: Use this variable to specify the path of your image rotation tool
*              On most systems, phpGraphy should be able to guess this value, however
*              if that fail you may find this handy.
* example: "/usr/bin/exiftran"
***/
$rotate_tool_path="";

/***
* directive: rotate_tool_args
* type: string
* from_version: 0.9.10
* description: Use this variable to redefine default arguments passed to the rotation tool.
*              Change this with care, normally defaults are fine.
* example: for jpegtran, "-copy all -perfect"
***/
$rotate_tool_args="";



/*****
*
* Display and Functions preferences
*
*****/


/***
* directive: nb_pic_max
* type: int
* description: Maximum number of pictures per column (2 columns per page)
* example: "5" mean that you'll get 10 pictures per page
***/
$nb_pic_max=5; 

/***
* directive: highres_min_level
* type: int
* description:	Mininum level to be able to see high resolution pictures,
*		Value can be from 0 to 999.
*		"1" means that you need to be authenticated to see them,
*		"0" mean that everyone as access to them.
***/
$highres_min_level=1;

/***
* directive: use_comments
* type: boolean
* description: Enable or disable the use of the comments system
***/
$use_comments = 1;

/***
* directive: nb_last_commented
* type: int
* description: Numbers of pictures on the last commented pictures page
***/
$nb_last_commented = 10;

/***
* directive: use_rating
* type: boolean
* description: Enable or disable the use of the rating system
***/
$use_rating = 1;

/***
* directive: nb_top_rating
* type: int
* description: Numbers of pictures on the top rated pictures page
***/
$nb_top_rating = 10;

/***
* directive: use_exif
* type: boolean
* description:	Enable or disable the use of the EXIF metadata
*		If enabled, EXIF metadata will be displayed under each
*		picture that contains such information.
***/
$use_exif = 1;

/***
* directive: use_iptc
* type: boolean
* description:	Enable or disable the use of the IPTC metadata
*		If enabled, IPTC metadata will be displayed under each
*		picture that contains such information.
***/
$use_iptc = 1;

/***
* directive: iptc_title_field
* type: string
* description:	This define which IPTC field should be used to fill (if empty)
*		the picture title/description. For complete list of available fields,
*		please read the documentation Appendix (EXIF/IPTC keywords reference table)
* example: 'Iptc.ObjectName' or 'Iptc.Headline'
***/
$iptc_title_field="Iptc.ObjectName";

/***
* directive: language_file
* type: string
* description:	If you want to use another language than english, please specify here
*		the external language file. Please note that the english language will
*		still be used as fall-back, so if you get some english text, it's because
*		the external language file is incomplete. Please also note that if you
*		want to use your own customized language file, you need to create a file
*		called lang_cust.inc.php, phpGraphy will automatically load it if it exists.
*		Please refeer to chapter "Text, Language customization" in the manual.
* example: "lang_fr.inc.php"
***/
$language_file="";






/*****
*
* Database preference/settings
*
*****/


/***
* directive: database_type
* type: string
* description:	This define your database backend. Actually you can choose between
*		'file' for the fast text database and 'mysql' for MySQL.
* example: "file" or "mysql"
***/
$database_type="file";

// MySQL related variables
/***
* directive: sDB
* type: string
* description: Name of the database containing phpGraphy tables
***/
$sDB = "phpgraphy";

// sUser,sServer,sPass: login informations to your MySQL database
$sUser = "put_your_db_user";
$sServer = "localhost";
$sPass = "put_your_db_password";





/*****
*
* Behaviour related variables
*
*****/


/***
* directive: debug_mode
* type: int
* description:	Level of debugging information (Warning this may reveal details about your configuration).
*	0 = disabled, 1 = enabled, 2 = install, 3 = development/debuging
***/
$debug_mode = 2;


/***
* directive: use_session
* type: boolean
* description:	This enable/disable the session authentication scheme.
*		On some servers, it's not available/possible, you'll have to use cookie...
*		You can still used cookie authentication even if session is enabled,
*		simply check the 'Remember me' box on the login page.
***/
$use_session = 1;

/***
* directive: use_ob
* type: boolean
* description:	This enable/disable the "Output Buffering"
*		You can get performance improvement when activated
*		as well as border effects on certains pages.
*		This is an experimental feature.
***/
$use_ob = 0;

/***
* directive: use_flock
* type: boolean
* description:	This enable/disable the "File Locking" mechanism, this option is only used
*		with the fast text database, and is HIGHLY recommended to avoid data loss
*		due to concurrents writing access. It may be turned off on small sites but
*		if you've have to turn it off, I would rather recommend you to use MySQL.
***/
$use_flock = 1;

/***
* directive: use_sem
* type: boolean
* description:	This enable/disable the "Semaphore" mechanism, this option is used to
*		allow phpGraphy to launch one convert at a time so it won't eat all
*		your CPU when generating all thumbnails/lowres pictures.
*		This feature is still experimental, use it carrefully.
***/
$use_sem = 0;


/***
* directive: exclude_files_preg
* type: string
* from_version: 0.9.10
* description:	This variable contain a perl regexp (Regular Expression) 
* of files/directories to exclude when parsing directories.
* Please modify it carefully as an improper value may break your whole site
* and/or render previously invisible files visible.
***/
$exclude_files_preg = "/^(\..*|_comment|thumbs.db)/i";



/*****
*
* Historical variables that will change in the near future, please avoid to change
*
*****/

$sTable = "descr";
$sTableUsers = "users";
$sTableComments = "comments";
$sTableRatings = "ratings";

?>
