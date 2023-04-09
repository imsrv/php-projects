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
*  $Id: functions_global.inc.php 97 2005-06-24 20:26:24Z jim $
*
*/

/*
This file will progressivly integrate all phpGraphy functions
in order to render the code easier to read.
*/

// Custom Error Handling function

function cust_error_handler($errormsg, $errorno=1, $log=null) {

   global $debug_mode, $data_dir;

// When debug_mode is set, this function return every error, else it will just return 
// msgs starting from error
                                                                                                        
$errormsgtype=array(
        1 => "WARNING",         // msg only
        5 => "ERROR",           // msg only
        9 => "FATALERROR"       // msg and die
        );
                                                                                                        
if (!isset($errormsgtype[$errorno])) cust_error_handler("Wrong usage of the error handler",1);
                                                                                                        
$txt_errormsg=date("Y-m-d H:i:s")." DEBUG: ".$errormsg."\n";
$html_errormsg="<div class=\"errormsg\"><b>".$errormsgtype[$errorno]."</b>: ".$errormsg."</div>";

if ($log) {
   // This log file will very useful to debug problem related with thumb_generator as we can not output anything
   error_log($txt_errormsg, 3, $data_dir."/debug.log");
   return;
   }

switch ($errorno) {
  case 1:
    if ($debug_mode) echo $html_errormsg;
    break;
  case 5:
    echo $html_errormsg;
    break;
  case 9:
    die($html_errormsg);
  }
                                                                                                        
} // EOF cust_error_handler()


// Return an array with all files in the given dir (skipping working dirs/files like .thumbs, .welcome, etc...)

function scan_dir($dir = '.', $search_pattern = NULL) {

	global $root_dir, $exclude_files_preg;

  // Both values below are the same as scanning from root_dir
	if ($dir == '.' || $dir == '/') $dir="";

  $fulldir=str_replace("//","/",$root_dir."/".$dir);
  if (!is_array($result)) $result=array();
	
	if (!is_dir($fulldir)) {
		cust_error_handler("'$fulldir' is not a directory", 5);
		return false;
		}

	if (!$dh  = opendir($fulldir)) {
		cust_error_handler("Unable to open '$fulldir'", 5);
		return false;
		}

	while (false !== ($filename = readdir($dh))) {
		unset($match);
		
		// Skipping directories and files contained in $exclude_files_preg
		if (preg_match($exclude_files_preg, $filename)) continue;

		// Normalizing the path
		$fullpath=str_replace("//","/",$fulldir."/".$filename);

	  if (is_dir($fullpath)) {
       if ($temp_array=scan_dir($dir."/".$filename,$search_pattern)) 
				   $result = array_merge($result,$temp_array);
			 } else {

				    if (isset($search_pattern)) {
							 if (preg_match($search_pattern, $filename)) $match=1;
							 } else $match=1;
					
						if (isset($match)) $result[]=$fullpath;
						}

    }

  if ($result) return $result; else return;

} // EOF scan_dir()

?>
