<?php 
/*
*  Copyright (C) 2004-2005 JiM / aEGIS (jim@aegis-corp.org)
*  Copyright (C) 2000-2001 Christophe Thibault
*  Rating system added by sIX / aEGIS (six@aegis-corp.org)
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
*  $Id: index.php 196 2005-10-18 16:10:10Z jim $
*
*/

/*
*  Feel free to modify anything you want here but remember that then, it's gonna be difficult
*  to upgrade so you better contact me so we can discuss about what you would like to change
*  and/or customize and if it make sense, you'll perhaps see what you've requested...
*  ...in the next release ! 
*
*  Remember, it's also YOU that help me to make/keep phpGraphy what it is actually !
*
*					JiM / aEGIS (jim@aegis-corp.org)
*/


// Security section (to avoid some possible hacks when config not properly filled and register_globals to on)

if (function_exists('ini_get') && ini_get('register_globals')) {
   unset($admin_ip);
   unset($root_dir);
   unset($data_dir);
   unset($language_file);
   unset($database_type);
   unset($highres_min_level);
   unset($sDB);
   unset($sUser);
   unset($sPass);
   unset($use_session);
   unset($use_comments);
   unset($use_rating);
   unset($use_exif);
   unset($use_iptc);
   unset($use_sem);
   unset($use_flock);
   unset($use_ob);
}


/**********************************************
****        Constants declaration           ***
**********************************************/

define("INCLUDE_DIR", "include/");
define("LANG_DIR", "lang/");
define("PHPGRAPHY_VERSION","0.9.10a");



/**********************************************
****        Include section                 ***
**********************************************/


require_once "config.inc.php"; 
require_once INCLUDE_DIR."filetypes.inc.php";
require_once INCLUDE_DIR."functions_global.inc.php";
require_once INCLUDE_DIR."functions_graphical.inc.php";
include_once INCLUDE_DIR."yorsh-errorhandler.class.php";
include_once INCLUDE_DIR."yorsh-variablevalidation.inc.php";
if ($use_exif || $use_iptc) include_once INCLUDE_DIR."functions_metadata.inc.php";


if($database_type=="mysql") require_once INCLUDE_DIR."db_mysql.inc.php";
elseif($database_type=="file") require_once INCLUDE_DIR."db_file.inc.php";
else die("ERROR, Please choose either 'mysql' or 'file' as database type in your config file");



/**********************************************
****        Error Handler init              ***
**********************************************/

define('LOG_FILE', $data_dir.'debug.log');

// Set PHP error reporting to max level
error_reporting(E_ALL ^ E_NOTICE);

// Define parameters depending of $debug_mode

switch ($debug_mode) {

    case 0:
        define('ERROR_REPORT_LEVEL', 'FATAL');
       // error_reporting(0);
        $error_display = 1;
        $error_log = 1;
        $error_verbose = 0;
        $error_generic = 1;

        break;

    case 1:
        define('ERROR_REPORT_LEVEL', 'ERROR');
        $error_display = 1;
        $error_log = 1;
        $error_verbose = 0;
        $error_generic = 0;

        break;

    case 2:
        define('ERROR_REPORT_LEVEL', 'WARNING');
        $error_display = 1;
        $error_log = 1;
        $error_verbose = 0;
        $error_generic = 0;

        break;

    case 3:
        define('ERROR_REPORT_LEVEL', 'DEBUG');
        $error_display = 1;
        $error_log = 1;
        $error_verbose = 1;
        $error_generic = 0;

        break;

    default:
        die("ERROR, Incorrect value for \$debug_mode, please read the manual or refer directly to the config file to correct the problem");

}

if ($_GET['displaypic'] || $_GET['previewpic']) {
    // Disable error display for picture/thumb display (background operations)
    $error_display = 0;
}

$error_handler =& new YorshErrorHandler($error_display, $error_log, $error_verbose, $error_generic);


/**********************************************
****        Session handling                ***
**********************************************/


if ($use_session) {
   if (is_writable(session_save_path())) {
      // Line below added so the page is still W3C valid
      if (function_exists("ini_set")) ini_set("arg_separator.output","&amp;");
      session_start();
      }
      else trigger_error("\$use_session is set to 1 in the config file but the server session_save_path ".session_save_path()." is currently not writable - correct the directory problem or disable the sessions use", ERROR);
   }


/**********************************************
****    Configuration check & Init          ***
**********************************************/


if (is_readable(LANG_DIR.'lang_en.inc.php')) include_once LANG_DIR."lang_en.inc.php"; else trigger_error("Can NOT open the default language file 'lang_en.inc.php'", FATAL);

/* Check performed normally only performed once for the first install */
if ($debug_mode >= 2) {
// Check that each directory variable has a trailing  / at the end

    // Directory creation test (mandatory)
    $test_dir=$root_dir.".thumbs";
    if (!is_dir($test_dir)) {
        if (!@mkdir($test_dir)) trigger_error("I was not able to create a subdirectory in your pictures directory, you should check the permissions or perhaps the mkdir function has been disabled, if this is the case phpGraphy won't be able to run correctly", FATAL);
	}

    if ($database_type == "file") {

        if (!is_dir($data_dir)) trigger_error("Please configure correctly the data directory in your config file", FATAL);
        if (!is_writable($data_dir)) trigger_error("Your data directory is NOT writable, check the permissions", FATAL);
        
        // Check users.dat file exists, if not assume it's a new installation
        if (!file_exists($users_filepath)) {
            $install_mode = 1;
        }

    } elseif ($database_type == "mysql") {

        if (!db_check_struct()) {
            $error_handler->setDisplay(0);
            trigger_error("Unable to find phpgraphy tables, trying to create the tables", WARNING);
            $error_handler->setDisplay(1);
            if (!db_create_struct_from_file()) 
                trigger_error("While trying to create the database structure, try reloading the page", ERROR);
            else
                $error_handler->setDisplay(0);
                trigger_error("Tables successfully created", WARNING);
                $error_handler->setDisplay(1);
        }

        // Check if there is an admin account, if not set install mode
        if (!db_check_admin()) $install_mode = 1;

    }


}

if (!is_readable($root_dir)) trigger_error("Please configure correctly the root_dir directory in your config file", FATAL);

// Handling $thumb_generator

if ($thumb_generator == "auto") {

    // Trying to auto-detect a thumb/lowres picture generator
    if (@exec("which convert", $my_convert_path)) {

        $thumb_generator="convert";

    } elseif ($my_convert_path[0]=="" && function_exists(gd_info)) {

      $thumb_generator="gd";

    } else {
        // Fall-back to manual

   	    trigger_error("Autodetection of the thumb_generator failed, you should either try to force a specific one (convert or gd) or use the manual way", ERROR);
        $thumb_generator="manual";

    }

} else {

// thumb/lowres picture generator specified, check if working

    if ($convert_path) {

        $my_convert_path[0]=$convert_path;
        if (!@exec($my_convert_path[0])) trigger_error("Could not run your convert executable, please correct the path you've specified in the config file or consider using 'gd' or 'manual' as thumb generator", ERROR);

    } else if($thumb_generator=="convert") {

        @exec("which convert", $my_convert_path);
        if ($my_convert_path[0]=="") trigger_error("Could not find convert, try to specify its path directly in the config or consider using 'gd' or 'manual' as thumb generator", ERROR);

    }

    if($thumb_generator=="gd" && !function_exists(gd_info)) trigger_error("You have choosen GD as thumb generator but your php isn't compiled with GD support, consider using 'convert' or 'manual' as thumb generator.", ERROR);

}


// Handling of $rotate_tool (only display output in debug file
$error_handler->setDisplay(0);

if ($rotate_tool == "auto") {
    if (@exec("which exiftran", $exiftran_path)) {

        trigger_error("DEBUG: using exiftran as rotate_tool", E_USER_NOTICE);
        $rotate_tool="exiftran";

    } elseif (@exec("which jpegtran", $jpegtran_path)) {

        trigger_error("DEBUG: using jpegtran as rotate_tool", E_USER_NOTICE);
        $rotate_tool="jpegtran";


    } else {

        // Disable rotation tool & display an error msg
        $rotate_tool = "manual";
        trigger_error("Auto-detection of the \$rotate_tool FAILED, you need to specify in the config file and probably its \$rotate_tool_path", WARNING);

    }

}
$error_handler->setDisplay(1);

if ($language_file) {
    if (is_file(LANG_DIR.$language_file)) {
        include_once LANG_DIR.$language_file;
    } else trigger_error("Can NOT open non-default language file '$language_file' defined in the config. ", ERROR);
}

// Defined here because it's better to only have ONE external customized language file
$language_file_custom="lang_cust.inc.php";

if (is_file(LANG_DIR.$language_file_custom)) {
    include_once LANG_DIR.$language_file_custom;
}

if ($use_sem && !function_exists(sem_get)) {
    trigger_error("use_sem is actually set to active in your config file but your php was not compiled with the semaphore option. Please disable it as you may encounter problems", ERROR);
}

if ($use_exif && !is_dir($data_dir)) trigger_error("data directory not found. Please configure it correctly in your config file or disable the use of exif functions", WARNING);

if ($use_exif && !function_exists(exif_read_data)) trigger_error("\$use_exif is set 1 in your config file but your current PHP version doesn't support it, please disable the exif setting.", WARNING);

/* Check that all directories initialised in config have the trailing and if not correct '/'
   This way, the rest of the script will assume that they have this and not more check will
   be required */
// $fulldir=str_replace("//","/",$root_dir."/".$dir);


/**********************************************
****    Functions declarations              ***
**********************************************/


function set_cookie_login_val($val)
{
  setcookie("phpGraphyLoginValue",$val,time()+(3600*24*365*3),dirname($_SERVER['SCRIPT_NAME']),$_SERVER['SERVER_NAME']);
}

function set_cookie_commentname_val($val)
{
  setcookie("phpGraphyVisitorName",$val,time()+(3600*24*365),dirname($_SERVER['SCRIPT_NAME']),$_SERVER['SERVER_NAME']);
}

function get_level($pic) {
// Return the absolute level (Inherited) by checking all directory below
// and returning the higher level found
  if(!strstr($pic,"/")) {
    $l=get_level_db($pic);
    if($l!=0) return (int)$l;
    return (int)get_level_db($pic."/");
  }
  $l=get_level_db($pic);
  if($l!=0) return (int)$l;
  $l2=get_level_db($pic."/");
  if($l2!=0) return (int)$l2;
  return (int)(get_level(substr($pic,0,strrpos($pic,"/"))));
}

function get_level_real($pic) {
// Return the real picture/directory level by simply checking the DB)
  if(!strstr($pic,"/")) return (int)get_level_db($pic);
  $l=get_level_db($pic);
  if($l!=0) return (int)$l;
  $l2=get_level_db($pic."/");
  if($l2!=0) return (int)$l2;
  return (int)(get_level_real(substr($pic,0,strrpos($pic,"/"))));
}

function reformat($s)
{
  // ANTI HACK stuff
  if(substr($s,0,1)==".") $s="";
  if(substr($s,0,1)=="/") $s="";
  if($s) $s=stripslashes($s);
  if(strstr(dirname($s),"..")) $s="";
  if(strstr(dirname($s),"./")) $s="";
  if(strstr($s,".thumbs")) $s="";
  if(strstr($s,"/.")) $s="";
  if($s=="." || $s=="./") $s="";
  if($s==".." || $s=="../") $s="";
  return($s);
}

// Most used function (TODO: rewrite to find optimization)
function echo_pic($i)
{
    global $root_dir,$dir,$files;
    global $sDB,$nConnection;
    global $txt_x_comments, $txt_thumb_rating;
    global $use_iptc, $iptc_title_field;
    global $use_rating, $use_comments;
    global $debug_mode;

    $filename=$files[$i];

    $comment=get_comment($dir.$filename);
    $prfile=$root_dir.$dir."/.thumbs"."/thumb_".basename($filename);

    if (!file_exists($prfile)  && $use_iptc && $iptc_title_field
        && !$comment && preg_match("/\.jpe?g$/i",basename($filename))) {
        // Thumb not present, auto-adding IPTC description field to the db
        // TODO: Remove the ugly preg and replace it by an unique function that identify the file type

        $iptc_header=get_iptc_data($root_dir.$dir.$filename);
        if ($iptc_title=$iptc_header[$iptc_title_field]) {
            if (!db_update_pic($dir.$filename,$iptc_title,0)) {
                if ($debug_mode >= 2) 
                    trigger_error("DEBUG: FAILED to set title from IPTC field for $filename", DEBUG);
            }
            $comment=$iptc_title;
        }
     }

    if($comment=="") $comment=$filename;
    echo "<td><a href=\"?display=".rawurlencode($dir.$filename)."\" title=\"".$comment."\"><img src=\"?previewpic=".rawurlencode($dir.$filename)."\" alt=\"".$comment."\" class=\"";
    if (is_filetype($filename)) echo "icon"; else echo "thumbnail";
    echo "\" /></a></td>";
    echo "<td><a href=\"?display=".rawurlencode($dir.$filename)."\">".nl2br(htmlentities($comment))."</a>";

    if ($use_comments) {
        if (($nbc=get_nb_comments($dir.$filename))>0)
            echo "<br /><span class=\"small\">".$nbc." ".$txt_x_comments."</span>";
    }

    if ($use_rating) {
        if (($rtg=get_rating($dir.$filename))!==false)
            echo "<br /><br /><span class=\"small\">".$txt_thumb_rating."<b>".sprintf("%.1f", $rtg)."</b></span>";
    }

    echo "</td>";
}

// image convertion functions

function wait_convert_proc() {

  global $sem;

  register_shutdown_function("end_convert_proc");
  $sem=sem_get(31337);
  sem_acquire($sem);

}

function end_convert_proc() {

	global $sem;

  sem_release($sem);
  register_shutdown_function("");

}

function convert_image($sourcepic, $destpic, $res="800x600", $quality=60)
{
  global $my_convert_path,$thumb_generator, $use_sem, $debug_mode;

  // No ouput can be made during this process, when $debug_mode is set to 2, the whole process is logged
  // into a debug.log file located inside your $data_dir

  if($use_sem) wait_convert_proc();

  // Checking if picture is still being modified/uploaded
  if (filemtime($sourcepic) > (time()+2)) {
  	if ($debug_mode >= 2)
	   trigger_error("convert_image(): picture datetime is too recent, aborting process", WARNING);
  	return false;
	}

  if($thumb_generator=="convert") {
    // New way (removes any ICM, EXIF, IPTC, or other profiles that might be present in the input and aren't needed in the thumbnail)
    $cmd=$my_convert_path[0]." -size ".$res." -quality ".$quality." \"".$sourcepic."\" -resize ".$res." +profile \"*\" \"".$destpic."\"";
    if ($debug_mode >= 2) 
       trigger_error("DEBUG: convert_image(): (cmd: $cmd)", DEBUG );
    @exec($cmd);


  } else if($thumb_generator=="gd") {
    if ($debug_mode >= 2) trigger_error("DEBUG: convert_image(): generating picture using gd", DEBUG);
    if(eregi("\.(jpg|jpeg)$",$sourcepic))
      $im=imagecreatefromjpeg($sourcepic);
    else if (eregi("\.png$",$fn))
      $im=imagecreatefrompng($createfn);
    if ($im != "") {
      $dims=explode("x",$res);
      $newh=$dims[1];
      $neww=$newh/imagesy($im) * imagesx($im);
      if ($neww > imagesx($im)) {
        $neww=imagesx($im);
        $newh=imagesy($im);
      }
      if ($neww > $dims[0])
      {
        $neww=$dims[0];
        $newh=$neww/imagesx($im) * imagesy($im);
      }
      // Using TrueColor now, it requires GD 2.0.1 or later
      $im2=ImageCreateTrueColor($neww,$newh);
      ImageCopyResampled($im2,$im,0,0,0,0,$neww,$newh,imagesx($im),imagesy($im));
      if (eregi("\.(jpg|jpeg)$",$sourcepic)) imagejpeg($im2,$destpic,$quality);
      else if (eregi("\.png$",$fn)) imagepng($im2,$destpic);
      ImageDestroy($im);
      ImageDestroy($im2);
     } else {
      debug_image("Error loading file!");
     }
  }

  if($use_sem) end_convert_proc();
}

//show debug info in image format
function debug_image($str){
    $im = ImageCreate (150, 50); /* Create a blank image */
    $bgc = ImageColorAllocate ($im, 255, 255, 255);
    $tc  = ImageColorAllocate ($im, 0, 0, 0);
    ImageFilledRectangle ($im, 0, 0, 150, 30, $bgc);
    /* Output an errmsg */
    ImageString ($im, 1, 5, 5, $str, $tc);
    ImageJPEG($im);
}

// comments functions

function display_comments($picname)
{
  global $sDB,$nConnection,$sTableComments,$admin;
  global $txt_comments,$txt_add_comment, $txt_del_comment, $txt_comment_from,$txt_comment_on;
?>
  <table width="100%">
  <tr><td align="left">
<? if(get_nb_comments($picname)>0) { ?> 
  <span class="txtcomments"><? echo $txt_comments ?></span>
<? } ?>
  </td><td align="right">
  <a href="" onclick='enterWindow=window.open("?picname=<? echo rawurlencode($picname) ?>&amp;addcomment=1&amp;popup=1","commentadd","width=400,height=260,top=250,left=500"); return false'><? echo $txt_add_comment ?></a>
  </td></tr>
  </table>
<?
  echo "<div id=\"usercomments\">";
  $user_comments=get_user_comments($picname);
  for($i=0;$i<sizeof($user_comments);$i++)
  {
     echo "<span class=\"small\">".$txt_comment_from."<b>".htmlentities($user_comments[$i][0])."</b>".$txt_comment_on.$user_comments[$i][1];
     if($admin)
     {
       echo " | <a href=\"?display=".rawurlencode($picname)."&amp;delcom=".$user_comments[$i][4]."\">".$txt_del_comment."</a>";
     }
     echo "</span><br />";
     echo nl2br(htmlentities($user_comments[$i][2]))."<br />";
     echo "<br />";
  }
  echo "</div>";
}

function delete_pic($display,$mode=null) {

// Delete a picture from the disk and also its reference in the db
// if $mode == thumb then it only delete the lowres and the thumb of the picture

  global $root_dir;

  if ($mode != "thumb") db_delete_pic($display);
  $filename=$root_dir.$display;
  $thumbname=$root_dir.dirname($display)."/.thumbs/thumb_".basename($display);
  $lrname=$root_dir.dirname($display)."/.thumbs/lr_".basename($display);

  if ($mode != "thumb" && file_exists($filename))
     {
     if (!unlink($filename)) $error=1;
     }

  if (file_exists($thumbname))
     {
     if (!unlink($thumbname)) $error=1;
     }

  if (file_exists($lrname))
     {
     if (!unlink($lrname)) $error=1;
     }

if ($error) return false; else return true;

}


function delete_dir($dir,$delete_error=null) {

  global $root_dir;

  $fulldir=ereg_replace("//","/",$root_dir."/".$dir);

  if (!is_dir($fulldir)) return false;
  echo "<div><b>Deleting ".$fulldir."</b></div>";
  $dh  = opendir($fulldir);
  while (false !== ($filename = readdir($dh))) {
     if ($filename == ".." || $filename == ".") continue;
     $fullpath=ereg_replace("//","/",$fulldir."/".$filename);

     if (!is_writable($fullpath))
	{
        echo "Deleting ".$fullpath.": ";
	echo "Failed, will skip all subdirectories (Owner is '";
	$fileowner=posix_getpwuid(fileowner($fullpath));
	echo $fileowner[name]."')<br />";
	$delete_error++;
	continue;
	}

     if (is_dir($fullpath))
	{
	if (!delete_dir($dir."/".$filename,$delete_error)) $delete_error++;
	}
        else {
	     echo "Deleting ".$fullpath.": ";
             if (ereg("\.thumbs", $fulldir) || ereg("\.(jpg|jpeg|gif|png)$", $fulldir)) 
		{
		if (!unlink($fullpath))
		   {
	   	   echo "Failed<br />";
		   $delete_error++;
		   } else echo "OK<br />";
		}
	        else {
		     if (!delete_pic($dir."/".$filename))
			{
			echo "Failed<br />";
			$delete_error++;
			} else echo "OK<br />";
		     }
             }
     }


if (!$delete_error) {
   if (rmdir($fulldir)) return true;
   }

return false;
}

function check_welcome($dir) {
// This function need to be run before editing a .welcome file, it's checking if we'll be able to write the file and if not return an error with informations.

  global $root_dir;

  $filename=".welcome";
  $fullpath=ereg_replace("//","/",$root_dir."/".$dir."/".$filename);

  if (!is_file($fullpath) && !is_writable(dirname($fullpath))) {
     echo "<div class=\"errormsg\"><b>Aborting</b>, phpGraphy doesn't have enough rights to create a file in this directory, please check the file/directory permissions and reload this page when done</div>";
     return false;
     }

  if (is_readable($fullpath) && !is_writable($fullpath)) {
     echo "<div class=\"errormsg\"><b>Aborting</b>, phpGraphy doesn't have enough rights to modify the .welcome file, please check its permissions and reload this page when done</div>";
     return false;
     }

return true;

}

function read_welcome($dir) {

// Use file_get_contents that requires PHP >= 4.3.0

  global $root_dir;

  $filename=".welcome";
  $fullpath=ereg_replace("//","/",$root_dir."/".$dir."/".$filename);

if (!is_readable($fullpath)) return false;

  if ($filecontent=file_get_contents($fullpath))return $filecontent; else return false;

}

function write_welcome($dir,$welcomedata) {

  global $root_dir;

    if (!isset($welcomedata)) {
        trigger_error("DEBUG: Variable \$welcomedata is not set", DEBUG);
        return false;
    }

  $filename=".welcome";
  $fullpath=ereg_replace("//","/",$root_dir."/".$dir."/".$filename);
  
  if (!$welcomedata) { unlink($fullpath); return; }

  $fp=fopen($fullpath,'w');
  if (!$fp) {
     trigger_error('Failed to write in .welcome file.', ERROR);
     return false;
     }
   fputs($fp, stripslashes($welcomedata));
   fclose($fp);
   return true;

}

function display_2d_array($array,$class = null) {

// Input two-dimensions array, output table using optional specified class
// This function convert all HTML contents into HTML entities

if (!is_array($array)) return;

echo "<table class=\"".$class."\">";
$i=0;
foreach ($array as $key => $value) {
  echo "<tr class=\"rowbgcolor";
  if ($i%2) echo 2; else echo 1;
  echo "\"><td>".htmlentities($key)."</td><td>".htmlentities($value)."</td></tr>\n";
  $i++;
  }
echo "</table>";

}



/****************************************************************
****  $_REQUEST ($_GET / $_POST / $_COOKIE) input validation  ***
****************************************************************/

if (!$install_mode) {

    foreach ($_REQUEST as $varname => $value) {

        // Removing slashes if already added by magic_quotes_gpc
        // (We will handle the quote protection at the DB Layer)
        if (get_magic_quotes_gpc()) {
            $value=stripslashes($value);
        }

        if (check_variable($varname, $value)) {
            // Registering $varname in the global scope if not a COOKIE
            if (!isset($_COOKIE[$varname])) {

                // trigger_error("DEBUG: Registering \$".$varname." in the global scope", WARNING);
                $$varname=$value;

            }

        } else {

            // Unregistering variable from globalscope if registered by register_globals
            if (isset($$varname)) unset($$varname);
            trigger_error("DEBUG:".$varname." has not been registered in the global scope", DEBUG);

        }

    }
}


/******************************************************
****   Main program - $_REQUEST dependant behavior  ***
******************************************************/

// Output Buffering
if ($use_ob) ob_start();

// install ?

if ($install_mode) {

    include INCLUDE_DIR."functions_user-management.inc.php";
    unset($user_info);

    include "header.inc.php";
    echo '<div style="margin: 100px">';

    // Check if this is the correct IP address
    if ($admin_ip != $_SERVER['REMOTE_ADDR']) {

        echo '
            <h2>New installation detected</h2>
            Welcome to phpgraphy installation procedure, in order to create your administrator account,
            you need to edit your configuration file <b>config.inc.php</b> and set the variable <b>$admin_ip</b> with
            your IP address which is indicated below. This is to prevent other people to get access to your
            installation.
            <br /><br />

            Your IP address: <b>'.$_SERVER['REMOTE_ADDR'].'</b>
            <br /><br />

            If you\'re not the administrator of this website, please note that your access to this page has been logged.';

            // Log attempt
            $error_handler->setDisplay(0);
            trigger_error("Access to installation page from address ".$_SERVER['REMOTE_ADDR'], WARNING);
            $error_handler->setDisplay(1);

    } elseif (count($_POST)>0) {

        // PROCESS+SAVE USER INFORMATION

        // Force default
        $_POST['security_level'] = 999;
        $_POST['uid'] = -1;

        $user_info = process_user_information();

        $error_message = '';
        if(isSet($user_info['error'])) {
            $error_message = implode("<br>\n", $user_info['error']);
        } else {
            edit_user_information($user_info);
            echo '<span style="text-align: center">Your Administrator account <b>'.$user_info['login'].'</b> has been created successfully,
                  you can now access <a href="'.$_SERVER['SCRIPT_NAME'].'">your phpGraphy site</a>.
                  <br /><br />
                  Remember that most of the options of phpGraphy are changed via the configuration file <b>config.inc.php</b>, see <a href="http://phpgraphy.sourceforge.net/documentation.php" target="_blank">phpGraphy documentation</a> for more information.</span>';
        }

    } else {

        echo '
            <h2>New installation detected</h2>
            You\'re about to create an administrator account using the <b>'.$database_type.'</b> database, please fill-in the fields below :
            <br /><br />

            <div class="errormsg"><b>';
        if ($error_message) echo $txt_error["00800"];
        echo '</b> '.$error_message.' </div>
            <form name="user_management" id="user_management" method="post" action="">
            <table border=0>
                <tr>
                    <td>
                        <label for="login" title="'.$txt_login_rule.'">'.$txt_um_login.' :</label> 
                    </td>
                    <td>
                        <input id="login" name="login" type="text" title="'.$txt_login_rule.'" 
                        value="'.$user_info['login'].'" size="15" maxlength="20" tabindex="1">
                        <span class="legend">(ie: administrator)</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password" title="'.$txt_pass_rule.'">'.$txt_um_pass.' :</label>
                    </td>
                    <td>
                        <input id="password" name="password" type="password" title="'.$txt_pass_rule.'" 
                        value="'.$user_info['password'].'" size="15" maxlength="32" tabindex="2">

                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input id="submit" name="submit" type="submit" value="Submit" tabindex="4">
                    </td>
            </table>
            </form>

            <br /><br />

            This account will give you access to a lot of reserved functions like describing your pictures, create new users, protect directories, etc. Once created, use the login link on the top right to authenticate yourself.
            ';
    }   

    echo '</div>';
    include "footer.inc.php";

    // In all case we are going to exit because some tests are not performed while in install mode
    // and such may open the application to eventual security holes.
    exit;
}


// logout ?

if($logout) {
  if ($_COOKIE['phpGraphyLoginValue']) set_cookie_login_val("");
  session_unset();
  header("Location: ".$_SERVER['SCRIPT_NAME']);
  exit;
}

// logging in ?

unset($user_row);
$logged=0;

if ($startlogin) {

   if (!headers_sent()) {

      if ($user_row=db_is_login_ok($user,$pass)) {
         if ($rememberme) set_cookie_login_val($user_row["cookieval"]);
         $_SESSION['phpGraphyLoginValue']=$user_row["cookieval"];
         $logged=1;
         } else 
               {
               trigger_error("DEBUG: authentication of user '$user' FAILED", DEBUG);
               trigger_error("Authentication failed, invalid login/password", ERROR);
               $error_login=1;
               }

      } else trigger_error("In order for the authentication to work, you must resolve the error above", ERROR);

   }
elseif ($_COOKIE['phpGraphyLoginValue']) { // login cookie present ?

       if ($user_row=db_get_login($_COOKIE['phpGraphyLoginValue'])) $logged=1; 
          else trigger_error("Unable to authenticate with informations found in your cookie", WARNING);

   }
elseif ($_SESSION['phpGraphyLoginValue']) { // valid session present ?

       if ($user_row=db_get_login($_SESSION['phpGraphyLoginValue'])) $logged=1;
          else trigger_error("Session authentication error, try closing your browser or removing the session cookie", WARNING);

   }

$admin=($user_row["seclevel"]==999);


// pic rating update ?

if ($display && $rating) {

    if (!already_rated($display) && $rating > 0 && $rating <= 10) {

        if (!db_add_rating($display,$rating)) {
            trigger_error("An error has occured while recording rating", E_USER_NOTICE);
        }

    } else {
        trigger_error("Rating value should be between 1 and 10", E_USER_WARNING);
    }

}

// pic comment update ?

if($updpic=="1" && $admin) db_update_pic($display,$dsc,$lev);

// dir level update ?

if($dirlevelchange && $admin) db_update_pic($dir,"",$dirlevel);



// FIXME: Fix for the bug #1181369 found in 0.9.9, this would probably requires a nicer patch
if($display && (dirname($display) != ".")) $dir=dirname($display);

if(substr($root_dir,-1)!='/') $root_dir.='/';
if($dir && substr($dir,-1)!='/') $dir.='/';

// dir creation ?

if($dircreate && $dircreate != "" && $admin) {
  if (!mkdir($root_dir.$dir.$createdirname,0755)) trigger_error("Unable to create ".$dir, ERROR);
}

// file uploaded ?
if ($admin && $picupload && is_array($_FILES['pictures'])) {

    trigger_error("DEBUG: File upload detected", E_USER_NOTICE);

    foreach ($_FILES["pictures"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
            $name = basename($_FILES['pictures']['name'][$key]);
            $destpath = $root_dir.$dir."/";
            trigger_error("DEBUG: Adding uploaded file \"$name\" to $destpath", DEBUG);
            move_uploaded_file($tmp_name, $destpath.$name);
        }
    }

}

// file copy from an url ? (Need PHP 4.3.0)
if ($admin && $copyfromurl && $userurl) {

$filename=basename($userurl);
$full_dir=$root_dir.$dir;

if (is_writable($full_dir)) {
   copy($userurl,$full_dir.$filename);
   } else trigger_error("Unable to write in $dir", ERROR);
}


// adding comment ?

if(isset($addingcomment) && (trim($comment) || trim($user))) {
  $picname=reformat($picname);
  if ($rememberme && $user) set_cookie_commentname_val($user);
  if (!$rememberme && $_COOKIE['phpGraphyVisitorName']) set_cookie_commentname_val("");
  db_add_user_comment($picname,$comment,$user);
 ?> <html><script language="javascript">window.opener.location="?display=<? echo rawurlencode($picname) ?>";window.close();</script></html> <? 
  exit;
}

// deleting comment ?

if($delcom&&$admin) db_del_user_comment($display,$delcom);

// updating .welcome ?

if ($updwelcome && isset($welcomedata) && check_welcome($dir)) {
if (strlen($welcomedata) < 10000) {
   write_welcome($dir,$welcomedata);
   echo "<html><script language=\"javascript\">window.opener.location=\"?dir=".rawurlencode($dir)."\";window.close();</script></html>";
   } else echo "Sorry more data (10k) than allowed, protection aborting the operation<br />";
   exit;
}

// rotating image ?

// NB: As we use the user input validation now, we won't re-check the validity of the input

if ($admin && $display && $rotatepic) {

    // Get the rotation value (1, 2 or 3)
    $rotate_value=$rotatepic;

    // We first delete the lowres and thumb as they won't be valid anymore
    delete_pic($display,"thumb");

    trigger_error("DEBUG: calling rotate_image($display,$rotate_value)", E_USER_NOTICE);
    rotate_image($root_dir.$display, $rotate_value);

}

// picture displaying ?

if($displaypic && get_level($displaypic)<=(int)$user_row["seclevel"]) {
  header("Content-type: image/jpeg");

  if(filesize($root_dir.$displaypic)>=$lr_limit && !$non_lr) {
    // switch to lr_mode
    $lrdir=$root_dir.dirname($displaypic)."/.thumbs";
    $lrfile=$lrdir."/lr_".basename($displaypic);
    if(!file_exists($lrfile)) {
      if (!is_dir($lrdir)) {
      	 if (!@mkdir($lrdir,0755)) {
            trigger_error("mkdir($lrdir) failed", ERROR);
	    }
	 }
      convert_image($root_dir.$displaypic,$lrfile,$lr_res,$lr_quality);
    }
    readfile($lrfile);
  } elseif (filesize($root_dir.$displaypic)<$lr_limit || (int)$user_row["seclevel"]>=$highres_min_level) readfile($root_dir.$displaypic);
  exit;
}

if($previewpic && get_level($previewpic)<=(int)$user_row["seclevel"]) {
  if ($ft=is_filetype($previewpic)) {
     header("Content-type: ".$ft["mime"]);
     readfile($icons_dir.$ft["icon"]);
     exit;
     }
  header("Content-type: image/jpeg"); 
  $prdir=$root_dir.dirname($previewpic)."/.thumbs";
  $prfile=$prdir."/thumb_".basename($previewpic);
  if(!file_exists($prfile)) {
    // No thumbnail found, generating one
    if (!is_dir($prdir)) {
       if (!@mkdir($prdir,0755)) {
          trigger_error("mkdir($prdir) failed", ERROR);
          }
       }
    convert_image($root_dir.$previewpic,$prfile,$thumb_res,$thumb_quality);
  }
  readfile($prfile);
  exit;
}

// if random picture, pickup a random pic and assign it to $display

if (isset($random)) {

    $level = 0;
    if ($logged) $level = (int)$user_row["seclevel"];
    $ok = 0;
    srand ((double) microtime() * 1000000);

    # FIXME: Improve the file type recognition
    if ($find_ar=scan_dir('/', '/.(jpe?g|gif|png)$/i')) {

        $l=sizeof($find_ar) - 1;
        for($try=0;!$ok && $try<32;$try++) {
            $random_nb=rand(0,$l);
            $pickline=substr($find_ar[$random_nb],strlen($root_dir));

            if (get_level($pickline) <= $level) $ok = 1;

        }

        if ($ok) {
            $display = $pickline;
            $dir = substr($display,0,strrpos($display,"/"))."/";
        }

    }
}

// pic delete
if($updpic=="del"&&$admin) {
  delete_pic($display);
  //jump back to the directory after deleting the pic
  $dir=dirname($display);
  header("Location: ./?dir=$dir&startpic=$i");
  exit;
}

// Delete thumbs and lr pictures (handful function when generation has failed for some reasons)
if($updpic=="delthumb"&&$admin) {
  delete_pic($display,"thumb");
  //jump back to the directory after deleting the pic
  $dir=dirname($display);
  header("Location: ./?dir=$dir&startpic=$i");
  exit;
}

// test if handled filetypes from filetypes.inc.php
if ($display) {
  if($ft=is_filetype($display)) {
    header("Content-type: ".$ft["mime"]);
    header("Content-Disposition: inline; filename=".basename($display));
    readfile($root_dir.$display);
    exit;
  }
}

// New way to check security, if not allowed, to redirect to the login page

// Protection against unauthorized directory viewing
$url="http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/?dir=".$dir."&login=1";
if ((get_level($dir) > (int)$user_row["seclevel"]) && !$login) 
   header("Location: ".$url);

// Protection against unauthorized picture viewing
$url="http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/?display=".$display."&login=1";
if ((get_level($display) > (int)$user_row["seclevel"]) && !$login) 
   header("Location: ".$url);

?>

<? include "header.inc.php" ?>

<? if ($admin && $debug_mode >= 2) cust_error_handler(" INSTALL/DEBUG mode is active - Lower the value of \$debug_mode in config.inc.php once you're done.", 1); ?>

<? // Login form

if($login) {
?>
<form method=POST action="<? echo basename($_SERVER['SCRIPT_NAME']); ?>" name="login">
<table id="loginform">
<tr><td><? echo $txt_login_form_login ?></td><td><input name="user" size=20></td></tr>
<tr><td><? echo $txt_login_form_pass ?></td><td><input type="password" name="pass" size=20></td></tr> 
<tr><td></td><td class="small">
<?
if ($use_session) {
   // Will only display this box is we can use session, else force the cookie use
   echo "<input type=\"checkbox\" name=\"rememberme\">".$txt_remember_me;
   } else echo "<input type=\"hidden\" name=\"rememberme\" value=\"on\">";
?>
</td></tr>
<tr><td colspan=2>
<input type="hidden" name="startlogin" value="1">
<input type="hidden" name="dir" value="<? echo $dir ?>">
<input type="submit" value="Login">
</td></tr></table>
</form> 
<?
  include "footer.inc.php";
  exit;
} else if($create&&$admin) {

// Create directory form

echo "Current directory : ".$dir."<br />";
?>
<form method=POST action="<? echo basename($_SERVER['SCRIPT_NAME']); ?>" name="createdir">
<? echo $txt_dir_to_create ?> <input name="createdirname" size=50><br />
<input type="hidden" name="dircreate" value="1">
<input type="hidden" name="dir" value="<? echo $dir ?>">
<input type="submit" value="Create">
</form> 
<?
  include "footer.inc.php";
  exit;
} else if($upload&&$admin) {

// Upload file form

echo $txt_current_dir." ";
if (trim($dir) != "") echo "(".$dir.")"; else echo "root/";
echo "<br />";
echo "<br /><hr width=\"300\"><br />";
echo "<div>".$txt_upload_file_from_user."</div><br />";

// Assigning a default value to $nb_ul_fields
if (!$nb_ul_fields || $nb_ul_fields > 10) $nb_ul_fields = 5;

?>
<form name="uploadfields" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="GET">
<?php echo $txt_file_to_upload ?>
<input type="hidden" name="upload" value="1">
<input type="hidden" name="dir" value="<? echo $dir ?>">
<select name="nb_ul_fields" onchange="checkUploadField('<?php echo $txt_upload_change ?>')">
    <option value="1" <?php if (!$nb_ul_fields || $nb_ul_fields == 1) echo "selected" ?>>1</option>
    <option value="5" <?php if ($nb_ul_fields == 5) echo "selected" ?>>5</option>
    <option value="10" <?php if ($nb_ul_fields == 10) echo "selected" ?>>10</option>
</select>
</form>
<form name="fileupload" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" enctype="multipart/form-data" method="post">
<br>
<input name="pictures[]" id="firstpicturefield" size="55" maxlength="100" type="file"><br>
<?php for ($i < 0; $i < $nb_ul_fields - 1;$i++) { ?>
<input name="pictures[]" size="55" maxlength="100" type="file"><br>
<?php } ?>
<input id="submitupload" value="Upload" type="submit">
<input name="picupload" value="1" type="hidden">
<input type="hidden" name="dir" value="<? echo $dir ?>">
</form>

<?php
if (version_compare(phpversion(), "4.3.0", ">=") && function_exists('ini_get') && ini_get('allow_url_fopen')) {
   // Copy from URL is only available since 4.3.0
   echo "<br /><hr width=\"300\"><br />";
   echo "<div>".$txt_upload_file_from_url." (http:// or ftp://)</div><br />";
?>
<form method="POST" action="<?php echo basename($_SERVER['SCRIPT_NAME']); ?>" name="urlupload">
URL: <input type="text" name="userurl" size="50" maxlenght="100"><br />
<input type="submit" value="Upload">
<input type="hidden" name="copyfromurl" value="1">
<input type="hidden" name="dir" value="<?php echo $dir ?>">
<?php
  }
  echo "<br /><br /><div style=\"text-align: left\"><a href=\"?\">".$txt_go_back."</a></div>";
  include "footer.inc.php";
  exit;
} else if($addcomment && $use_comments) {

 // "Add comment" popup window

  $picname=reformat($picname);
  ?>
    <form name="addcomment" method=POST>
    <? echo $txt_comment_form_name ?><font face="Courier" size=1><input type=text name=user size=30 value="<? if ($_COOKIE['phpGraphyVisitorName']) echo $_COOKIE['phpGraphyVisitorName']; ?>"></font>
    <input type="checkbox" name="rememberme"<? if ($_COOKIE['phpGraphyVisitorName']) echo "checked"; ?>>
    <span class="small"><? echo $txt_remember_me ?></span><br />
    <? echo $txt_comment_form_comment ?> <br /><font face="Courier" size=1><textarea name=comment cols=40 rows=3></textarea></font><br />
    <br />
    <input type=submit value="<? echo $txt_add_comment ?>">
		<button type=button onclick="window.self.close();"><? echo $txt_cancel ?></button>
    <input type=hidden name=addingcomment value="1">
    <input type=hidden name=picname value="<? echo $picname ?>">
    </form>
    <script language="javascript">document.addcomment.<? if ($_COOKIE['phpGraphyVisitorName']) echo "comment"; else echo "user"; ?>.focus();</script>
  <?
  include "footer.inc.php";
  exit;
} else if($editwelcome) {

 // "Edit .welcome" popup window

?>
  <? echo $txt_editing." '.welcome' ".$txt_in_directory." ".$dir." :<br />"; ?>
	<span class="small">(HTML content and line breaks are supported)</span> 
  <? if (check_welcome($dir)) { ?>
  <form name="editwelcome" method=POST>
  <input type="hidden" name="updwelcome" value="1">
  <textarea name="welcomedata" cols="87" rows="15" wrap="off" class="medium"><? echo read_welcome($dir) ?></textarea><br />
  <button type=submit ><? echo $txt_save ?></button>
  <button type=button onclick="window.self.close();"><? echo $txt_cancel ?></button>
  <button type=button onclick="document.editwelcome.welcomedata.value=''; return true;"><? echo $txt_clear_all ?></button>
  </form>
<?
    }
    include "footer.inc.php";
    exit;

} else if($lastcommented && $use_comments) {

    // Display last commented pictures

    $lastcommented=reformat($lastcommented);

    $c=get_last_commented($lastcommented,$nb_last_commented,(int)$user_row["seclevel"]);

    echo "<div class=\"title\">".$txt_last_commented_title."</div>";
    echo "<table border=\"0\">";

    for($i=0;$i<sizeof($c);$i++) {

        if (is_array($c[$i])) {

            $pic=$c[$i][0];
            $comment=get_comment($pic);
            if (trim($comment) == "") $comment=$pic;

            echo "<tr><td>";
            echo "<a href=\"?display=".rawurlencode($pic)."\"><img src=\"?previewpic=".rawurlencode($pic)."\" alt=\"".$comment."\" class=\"thumbnail\" /></a>";
            echo "</td><td>";
            echo "<span class=\"small\">";
            echo $c[$i][1]." ".$txt_comment_by." <b>".stripcslashes(htmlentities($c[$i][2]))."</b></span>";
            echo "<br /><a href=\"?display=".rawurlencode($pic)."\">".$comment."</a>";
            echo "</td></tr>";
        }

    }

    echo "</table>";
    echo "<span class=\"small\"><a href=\"?dir=".$lastcommented."\">".$txt_go_back."</a></span><br />";
    echo "<br />";
    include "footer.inc.php";
    exit;

} else if(isset($topratings) && $use_rating) { 

  // Display top rated pictures

  echo "<div class=\"title\">".$txt_top_rated_title."</div>";
  echo "<table border=\"0\">";
  $c=get_top_ratings("/", $nb_top_rating, (int)$user_row["seclevel"]);
  for($i=0;$i<sizeof($c);$i++) {
    if (is_array($c[$i])):

      $pic = $c[$i][0];
      $comment = get_comment($pic);
      if (trim($comment) == "") $comment=$pic;

      echo "<tr><td>";
      echo "<span class=\"small\">".($i+1)."</span> ";
      echo "<span style=\"text-align: center\"><a href=\"?display=".rawurlencode($pic)."\"><img src=\"?previewpic=".rawurlencode($pic)."\" alt=\"".$comment."\" class=\"thumbnail\" /></a></span>";
      echo "</td><td>";
      echo $comment;
      echo " <span class=\"small\">(<b>".sprintf("%.1f", $c[$i][1])."</b>)</span>";
      echo "</td></tr>";
    endif;
  }
  echo "</table>";
  echo "<span class=\"small\"><a href=\"?dir=\">".$txt_go_back."</a></span><br />";
  echo "<br />";
  include "footer.inc.php";
  exit;
}

// directory delete (recursive)

if($deldir && $dir && $admin) {
  if (delete_dir($dir)) echo "<b>Directory deleted successfully</b>"; else echo "<b>Problem while deleting this directory</b><br />(Please check errors msgs above, to resolve this you may have to delete (or change permissions) using your FTP access as it's very likely some pictures/directories belong to your FTP user.)";
  echo "<br />";
  echo "<span class=\"small\"><a href=\"?dir=\">Go back</a></span><br />";
  echo "<br />";
  include "footer.inc.php";
  exit;
}


// Generate all thumbnails/low res

if($genall && $admin) { 
  echo "Generating all missing thumbnails/low res pictures: (be patient)<br /><br />";
  flush();

  $gen_lr=0; $gen_th=0;
  // exec('find '.$root_dir.' -type f -print | egrep -i "\.(jpg|jpeg|gif|png)$" | grep -v ".thumbs/"',$find_ar);
	$find_ar=scan_dir('/', '/.(jpe?g|gif|png)$/i');
  for($i=0;$find_ar[$i];$i++) {
    $pic=substr($find_ar[$i],strlen($root_dir));
    $lrdir=$root_dir.dirname($pic)."/.thumbs";
    if(!is_dir($lrdir)) mkdir($lrdir,0755);

    // low res check
    if(filesize($root_dir.$pic)>=$lr_limit) {
      $lrfile=$lrdir."/lr_".basename($pic);
      if(!file_exists($lrfile)) {
        echo "Generating low res picture for $pic<br />";
        flush();
        convert_image($root_dir.$pic,$lrfile,$lr_res,$lr_quality);
        $gen_lr++;
      }
    }

    // thumbnail check
    $prfile=$lrdir."/thumb_".basename($pic);
    if(!file_exists($prfile)) {
      echo "Generating thumbnail picture for $pic<br />";
      flush();
      convert_image($root_dir.$pic,$prfile,$thumb_res,$thumb_quality);
      $gen_th++;
    }
  }

  echo "<br />";
	if ($gen_lr || $gen_th) 
		 echo "Generated <b>$gen_lr</b> low res pictures and <b>$gen_th</b> thumbnails.<br />";
	   else echo "Nothing to do. ";

  echo "Your library has <b>".sizeof($find_ar)."</b> pictures.<br />";
  echo "<span class=\"small\"><a href=\"?dir=\">".$txt_go_back."</a></span><br />";
  echo "<br />";
	include "footer.inc.php";
  exit;
}

// Users management

if($um && ($admin || $install_mode)) {
	echo '<a href="'.$_SERVER['SCRIPT_NAME'].'">'.$txt_go_back.'</a><br>';
	include INCLUDE_DIR."functions_user-management.inc.php";
	switch($action) {
        case 'edit':
            {
                unset($user_info);

                // PROCESS+SAVE USER INFORMATION
                if(count($_POST)>0) {
                    $user_info = process_user_information();

                    $error_message = '';
                    if(isSet($user_info['error'])) {
                        $error_message = implode("<br>\n", $user_info['error']);
                    } else {
                        edit_user_information($user_info);
                        die('<script type="text/javascript">document.location.href="'.$_SERVER['SCRIPT_NAME'].'?um=1"</script>');
                    }
                }

                // DISPLAY USER INFORMATION
                unset($uid);
                if(isSet($_GET['uid']) && is_numeric($_GET['uid'])) {
                    $uid = $_GET['uid'];
                } else {
                    trigger_error("uid variable missing or incorrect", FATAL);
                }

                if(!isSet($user_info)) {
                    $user_info = get_user_information($uid);
                }

                echo '
                    <!-- 
                    This form was inspired by this tutorial : 
                    http://www.fredcavazza.net/tutoriels/formulaire/SVF_intro.htm
                    -->
                    <form name="user_management" id="user_management" method="post" action="">
                    <div id="bodyForm">
                    <fieldset><legend>'.$txt_user_info.' | <a href="'.$SERVER['SCRIPT_NAME'].'?um=1">'.$txt_back_user_list.'</a></legend>
                    <div class="errormsg"><b>';
                if ($error_message) echo$txt_error["00800"];
                echo '</b> '.$error_message.' </div>

                    <p>
                    <label for="login" title="'.$txt_login_rule.'">'.$txt_um_login.' :</label> 
                    <input id="login" name="login" type="text" title="'.$txt_login_rule.'" 
                    value="'.$user_info['login'].'" size="10" maxlength="20" tabindex="1">
                    <span class="legend">ie: john</span>
                    </p>

                    <p>
                    <label for="password" title="'.$txt_pass_rule.'">'.$txt_um_pass.' :</label>
                    <input id="password" name="password" type="text" title="'.$txt_pass_rule.'" 
                    value="'.$user_info['password'].'" size="15" maxlength="32" tabindex="2">
                    </p>

                    <p>
                    <label for="security_level" title="'.$txt_sec_lvl_rule.'">'.$txt_um_sec_lvl.':</label>
                    <input id="security_level" name="security_level" type="text" title="'.$txt_sec_lvl_rule.'" 
                    value="'.$user_info['security_level'].'" size="3" maxlength="3" tabindex="3">
                    <span class="legend">ie: 3</span>
                    </p>
                    </fieldset>
                    </div>
                    <div id="bottomForm">
                    <input id="uid" name="uid" type="hidden" value="',$uid.'">
                    <input id="submit" name="submit" type="submit" value="Submit" tabindex="4">
                    </div>
                    </form>
                    ';
                break;
            }
        case 'display':
        default	:
            {
                if(isSet($_GET['delUser']) && is_numeric($_GET['delUser'])) {
                    delete_user($_GET['delUser']);
                    die('<script type="text/javascript">document.location.href="'.$SERVER['SCRIPT_NAME'].'?um=1"</script>');
                }

                $all_user_info = get_all_user_information($filename);

                echo "
                    <table class=\"um\">
                    <caption>$txt_user_management | 
                    <a href=\"".$SERVER['SCRIPT_NAME']."?um=1&action=edit&uid=-1\">$txt_add_user</a>
                    </caption>
                    <tr><th>$txt_um_login</th>
                    <th>$txt_um_pass</th>
                    <th>$txt_um_sec_lvl</th>
                    <th>$txt_um_edit</th>
                    <th>$txt_um_del</th>
                    </tr>
                    ";
                foreach($all_user_info as $user_id => $user) { 
                    echo "
                        <tr>
                        <td>{$user['login']}</td>
                        <td>".str_pad(NULL, strlen($user['login']), "*")."</td>
                        <td>{$user['security_level']}</td>
                        <td><a href=\"".$SERVER['SCRIPT_NAME']."?um=1&action=edit&uid=$user_id\">
                        <img src=\"".$icons_dir."/edit.png\" border=\"0\"></a></td>
                        <td>";
                    if ($user_row['login'] != $user['login']) echo "<a onClick=\"javascript:if(confirm('$txt_confirm_del_user')){document.location.href='".$SERVER['SCRIPT_NAME']."?um=1&delUser=$user_id';}\"><img src=\"".$icons_dir."delete_cross.gif\"></a>";
                    echo "
                        </td>
                        </tr>
                        ";
                }
                echo "</table>\n";
                break;
            }
    }
    include "footer.inc.php";
    exit;
}

/*******************************************
****   Main program - default behavior   ***
********************************************/

  // scan dir

$nb_dirs  = 0;
$nb_files = 0;
$dirs[0]  = "";
$files[0] = "";

if (!is_dir($root_dir.$dir)) trigger_error("The directory you've requested doesn't exists", FATAL);

$dh=dir($root_dir.$dir);

while ($file=$dh->read()) {

    // if (preg_match($exclude_files_preg, $file)) continue;
    if (preg_match($exclude_files_preg, $file)) continue;

    if(is_dir($root_dir.$dir.$file)) {
        // directory
        if(get_level($dir.$file."/")<=(int)$user_row["seclevel"])
            $dirs[$nb_dirs++]=$file;
    } else {
        // file
        if(get_level($dir.$file)<=(int)$user_row["seclevel"])
            $files[$nb_files++]=$file;
    }

}

$dh->close();

sort($dirs);

if (file_exists($root_dir.$dir."/.desc"))
  rsort($files);
else
  sort($files);

?>

<table cellspacing="0" cellpadding="0" id="dirbar">
<tr><td id="dirbarleft">
<? 
  // display current dir

if(!$dir) echo $txt_root_dir."/";
else echo "<a href=\"?dir=\">".$txt_root_dir."</a>/";
$alldirs=explode("/",$dir);
$alldirtmp="";
for($i=0;$alldirs[$i];$i++) {
  $alldirtmp.=$alldirs[$i]."/";
  if($alldirs[$i+1] || $display) echo "<a href=\"?dir=".rawurlencode($alldirtmp)."\">";
  echo $alldirs[$i];
  if($alldirs[$i+1] || $display) echo "</a>/";
}
if ($nb_files || $nb_dirs) echo " - ";
if ($nb_dirs) echo $nb_dirs." ".$txt_dirs;
if ($nb_files && $nb_dirs) echo " - ";
if ($nb_files) echo $nb_files." ".$txt_files;
if ($use_comments) {
   echo " - <a href=\"?lastcommented=";
   if ($dir) echo rawurlencode($dir); else echo "/";
   echo "\">$txt_last_commented</a>";
   }
if (!is_writable($root_dir.$dir) && $admin) trigger_error("This directory is NOT writable, this may cause various problems <br />(eg: to generate thumbs/lowres pictures)", WARNING);

?>
</td><td id="dirbarright">
<? if(!$logged) { ?>
<a href="?dir=<? echo rawurlencode($dir) ?>&amp;login=1"><? echo $txt_login ?></a>
<? } else {
  echo $user_row["login"]." - "; 
  if($admin) {
    echo "<a href=\"?um=1\">".$txt_user_management."</a> - ";
    echo "<a href=\"?dir=".rawurlencode($dir)."&amp;create=1\">".$txt_create_dir."</a> - <a href=\"?dir=".rawurlencode($dir)."&amp;upload=1\">".$txt_upload."</a> - ";
    echo "<a href=\"?genall=1\">".$txt_gen_all_pics."</a> - ";
  } ?>
<a href="?logout=1"><? echo $txt_logout ?></a>
<? } ?>
<? if($txt_random_pic) { ?>
- <a href="?random=1"><? echo $txt_random_pic ?></a>
<? } ?>
</td></tr>
</table>

<?
// display admin form (edit directory security level, edit .welcome)

if($admin && !$display) {
  if ($dir) {
     echo "<form name=\"admindir\" method=POST>".$txt_dir_sec_lev."<input name=\"dirlevel\" value=\"".get_level_real($dir)."\" size=4>";
     echo "<input type=hidden name=dir value=\"".$dir."\">";
     echo "<input type=hidden name=dirlevelchange value=\"1\">";
     echo " <input type=submit value=\"".$txt_change."\">".$txt_inh_lev.get_level($dir)."</form>";
     }
  echo "<a href=\"\" onclick='enterWindow=window.open(\"?dir=".rawurlencode($dir)."&amp;editwelcome=1&amp;popup=1\",\"editwelcome\",\"width=650,height=400,top=150,left=200\"); return false'>".$txt_edit_welcome."</a>";
}
?>

<?
// display .welcome message if it exists

if(file_exists($root_dir.$dir.".welcome") && !$display && !$startpic) {
  echo "<div class=\"welcome\">";
  echo nl2br(file_get_contents($root_dir."/".$dir."/.welcome"));
  // readfile($root_dir."/".$dir."/.welcome"));
  echo "</div>";
}
?>

<?php

if (!$display) {

    // display dirs (if not in lowres/fullres browsing mode)

    echo "<div id=\"dirlist\">";

    if ($admin) {
        echo "<form name=\"deletedir\" method=\"GET\">";
        echo "<input type=\"hidden\" name=\"dir\" value=\"\">";
        echo "<input type=\"hidden\" name=\"deldir\" value=\"\">";
    }


    for($i=0;$i<$nb_dirs;$i++) {
        echo "&nbsp;&nbsp;<a href=\"?dir=".rawurlencode($dir.$dirs[$i])."\">".$dirs[$i]."</a> ";
        if ($admin) {
            echo "<a href=\"javascript:if(confirm('".$txt_delete_confirm."')){document.deletedir.deldir.value=1;document.deletedir.dir.value='".rawurlencode(addslashes($dir.$dirs[$i]))."';document.deletedir.submit();}\" onMouseOver=\"self.status='".$txt_delete_directory_text." ".addslashes($dirs[$i])."';return true;\" onMouseOut=\"self.status='';return true;\" title=\"".$txt_delete_directory_text." ".$dirs[$i]."\">";
            echo $txt_delete_directory_icon."</a>";
        }
        echo "<br />\n";
    }

    if ($admin) echo "</form>";
    echo "</div>";

}
?>

<?php

if(!$display) {

  // display the directory content (thumbs)

if ($nb_files) {

  if(!$startpic) $startpic=0;
  echo "<table id=\"dircontent\"><tr><td>\n";

  echo "<table id=\"dircontentleft\">\n";
  for($i=$startpic;$i<$nb_files && $i<($startpic+$nb_pic_max);$i++) {
    echo "<tr>";
    echo_pic($i);
    echo "</tr>\n";
    }
  echo "</table>\n";

  $startpic2=$i;
  if ($i<$nb_files && $i<($startpic2+$nb_pic_max)) {
    echo "<table id=\"dircontentright\">\n";
    for(;$i<$nb_files && $i<($startpic2+$nb_pic_max);$i++) {
      echo "<tr>";
      echo_pic($i);
      echo "</tr>\n";
      }
    echo "</table>";
    }

  echo "</td></tr></table>";
  }


// Page Naviguation (Previous/Next, Page Number)
if ($nb_pic_max*2 < $nb_files) {
    echo "<div class=\"pagenav\">";
   if ($startpic!=0) {
      $a=$startpic-($nb_pic_max*2);
      if ($a<0) $a=0;
      echo "<a href=\"?dir=".rawurlencode($dir)."&amp;startpic=".$a."\">".$txt_previous_page."</a> ";
      }

  if ($nb_pic_max*2 < $nb_files) {
     $nb_pages=ceil($nb_files/($nb_pic_max*2));
     for ($page_nb=1;$page_nb<=$nb_pages;$page_nb++) {
         $page_startpic=($page_nb*$nb_pic_max*2)-$nb_pic_max*2;
         echo " ";
         if ($page_startpic != $startpic) echo "<a href=\"?dir=".rawurlencode($dir)."&amp;startpic=".$page_startpic."\">";
         echo $page_nb;
         if ($page_startpic != $startpic) echo "</a>";
         echo " ";
         }
      }

   if ($i!=$nb_files) {
      echo "<a href=\"?dir=".rawurlencode($dir)."&amp;startpic=".$i."\">".$txt_next_page."</a>";
      }
   echo "</div>";
   }

?>

<? } else { 

   // display a picture (lowres/highres)

for($i=0;$i<$nb_files && basename($display)!=$files[$i];$i++);

echo "<div id=\"displaypicture\">";
echo "<span class=\"big\"><b>";
$comment=get_comment($display);
if ($use_iptc) {
   // Load IPTC comment
   $iptc_header=get_iptc_data($root_dir.$display);
   // if ($iptc_header[$iptc_title_field] && !$comment) $comment="AddedFromIPTC:".$iptc_header[$iptc_title_field];
   }
if($comment!="") echo nl2br(htmlentities($comment)); else echo basename($display);
echo "</b></span>";
if ($use_iptc && $admin) {
   echo "<span id=\"metadataicon\">"; 
   if ($iptc_header) { $metadata_icon="metadata_on.gif"; $metadata_status="Found IPTC metadata"; }
      else { $metadata_icon="metadata_off.gif"; $metadata_status="No IPTC metadata found"; }
   echo "<img src=\"".$icons_dir.$metadata_icon."\" alt=\"".$metadata_status."\" title=\"".$metadata_status."\" />";
   echo "</span>";
   }

echo "\n<div id=\"picnav\">";
if($i!=0) echo "<a href=\"?display=".rawurlencode($dir.$files[$i-1])."\">".$txt_previous_image."</a> ";

$startpic=0;
while ($i+1>$startpic+($nb_pic_max*2)) { $startpic=$startpic+$nb_pic_max*2; }
echo "<a href=\"?dir=".rawurlencode($dir)."&amp;startpic=".$startpic."\">$txt_back_dir</a>";

echo " (".($i+1)."/".$nb_files.") ";
if(filesize($root_dir.$display)>=$lr_limit && !$non_lr && (int)$user_row["seclevel"]>=$highres_min_level) echo " <a href=\"?display=".rawurlencode($display)."&amp;non_lr=1\">".$txt_hires_image."</a> ";
if(filesize($root_dir.$display)>=$lr_limit && $non_lr) echo " <a href=\"?display=".rawurlencode($display)."\">".$txt_lores_image."</a> ";

if($files[$i+1]) echo "<a href=\"?display=".rawurlencode($dir.$files[$i+1])."\">".$txt_next_image."</a>";

echo "</div>";

if ($use_rating) {
	echo "\n<div id=\"rating\">";
	$pic_rating=get_rating($display);
	if ($pic_rating===false) echo $txt_no_rating; else echo $txt_pic_rating."<b>".sprintf("%.1f", $pic_rating)."</b>";
	echo "<br />";
	if (!already_rated($display)) {
	   $rate_url="?display=".rawurlencode($display);
	   if (strpos($rate_url, "?")!==false) $rate_url.="&amp;rating="; else $rate_url.="?rating=";
	   echo "<select onchange='document.location.href=\"".$rate_url."\" + this.options[this.selectedIndex].value'>";
	   echo "<option value='null'>".$txt_option_rating."</option>";
	   for ($a=1;$a<=10;$a++) echo "<option value=\"$a\">$a</option>";
	   echo "</select>";
	   }
	echo "</div>";
}

if($admin) { ?>
<form name="updateform" id="picupdateform">
    <div id="picupdate.desc">
        <?echo $txt_description ?>
        <textarea name="dsc" cols=60 rows=2><? echo $comment ?></textarea>
    </div>
    <?php if ($rotate_tool != "manual" && preg_match("/\.jpe?g$/i", $display)) { ?>
    <div id="picupdate.rotate">
        <input type=hidden name=rotatepic value="0">
        Rotate: 
            <button onclick="javascript:document.updateform.rotatepic.value='3';document.updateform.submit();" class="rotatebutton"><?php echo $txt_rotate_270 ?></button>
            <button onclick="javascript:document.updateform.rotatepic.value='2';document.updateform.submit();" class="rotatebutton"><?php echo $txt_rotate_180 ?></button>
            <button onclick="javascript:document.updateform.rotatepic.value='1';document.updateform.submit();" class="rotatebutton"><?php echo $txt_rotate_90 ?></button>
    </div>
    <?php } ?>
    <div>
        <?echo $txt_sec_lev ?> <input name="lev" value="<? echo get_level_real($display) ?>" size=4>
        <input type=hidden name=display value="<? echo $display ?>">
        <input type=hidden name=updpic value="1">
        <? echo $txt_inh_lev.get_level($dir) ?>
        <input type=submit value="<?echo $txt_change?>">
        <input type=button value="<?echo $txt_delete_photo?>" onclick="javascript:if(confirm('<? echo $txt_delete_confirm ?>')){document.updateform.updpic.value='del';document.updateform.submit();}">
        <input type=button value="<?echo $txt_delete_photo_thumb?>" onclick="javascript:if(confirm('<? echo $txt_ask_confirm ?>')){document.updateform.updpic.value='delthumb';document.updateform.submit();}">
    </div>
</form>
<? }

// display comment message if it exists

if(file_exists($root_dir.$display."_comment")) {
  echo "<div class=\"welcome\">";
  readfile($root_dir.$display."_comment");
  echo "</div>";
}

if(get_level($display)<=(int)$user_row["seclevel"]) {
 if (isset($random)) echo "<a href=\"?random=1\"  title=\"$txt_next_image\">";
 else if($files[$i+1]) echo "<a href=\"?display=".rawurlencode($dir.$files[$i+1])."\" title=\"$txt_next_image\">";
?>
<img src="?displaypic=<? echo rawurlencode($display) ?>&amp;non_lr=<? echo $non_lr ?>" alt="<? if($files[$i+1]) echo $txt_next_image; else echo $comment ?>" class="picture" /><br />
<? 
if($random || $files[$i+1]) echo "</a>";
   } ?>
</div>
<br />
<?

if ($use_exif && preg_match("/\.jpe?g$/i", $display)) $exif_header=get_exif_data($root_dir.$display);
if ($use_exif && !empty($exif_header)) {
   $metadata=$exif_header;
   echo "<div class=\"exifmetadata\">";
   echo reformat_exif_txt($txt_exif_custom,$exif_header);
   echo "</div>";
   }

// $iptc_header has already been loaded before the picture description
if ($use_iptc && !empty($iptc_header)) {
   if (is_array($exif_header)) $metadata=$exif_header + $iptc_header; else $metadata=$iptc_header;
   echo "<div class=\"iptcmetadata\">";
   echo reformat_iptc_txt($txt_iptc_custom,$iptc_header);
   echo "</div>";
   }

if (($use_exif && !empty($exif_header)) || ($use_iptc && !empty($iptc_header))) {
   echo "<div style=\"text-align: center\"><a href=\"javascript:switch_display('metadatadiv')\">".$txt_show_me_more."</a></div>";
   echo "<div id=\"metadatadiv\" style=\"display:none\">";
   display_2d_array($metadata,'metadatatable');
   echo "</div>";
   }

if ($use_comments) display_comments($display);


} ?>

<? include "footer.inc.php" ?>

<?
// Output Buffering
if ($use_ob) ob_end_flush();
?>
