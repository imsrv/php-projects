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
*  $Id: db_file.inc.php 154 2005-09-24 14:35:29Z jim $
*
*/

// This emulates a database using simple pipe separated values text files
// It uses php arrays for caching data


$users_filepath    = $data_dir."users.dat";
$rating_filepath   = $data_dir."ratings.dat";
$comments_filepath = $data_dir."comments.dat";


function quote_smart($input)
{

    // This function is an 'equivalent' to the quote_smart for MySQL
    // It escape all dangerous ASCII characters and also
    // encode the pipe character as it's used as field separator

    $output = str_replace("|", "%7C", $input);
    $output = addcslashes($output,"\0..\37!@\177..\377");

    return $output;

}

function unquote_smart($input)
{

    $output = stripcslashes($input);
    $output = str_replace("%7C", "|", $output);

    return $output;

}


function get_picture_data($name) {

	global $db_picdata,$db_datloaded;
  global $root_dir, $use_flock;

  $datname=$root_dir.dirname($name)."/.thumbs/pictures.dat";

  if($db_datloaded[$datname]) return $db_picdata[$name];

	if(!file_exists($datname)) return;
  
	$fh=fopen($datname,"rt");
	if ($use_flock) flock($fh,LOCK_SH);

	while(!feof($fh)) {
      $line=fgets($fh,4096);
      if(!$line) continue;
      $a=explode("|",$line);
      $db_picdata[$a[0]]=$a;
	    }

  fclose($fh);
  $db_datloaded[$datname]=1;
  return $db_picdata[$name];
}

function load_rating_data() {

  global $db_ratingdata,$db_ratingloaded,$db_ratingip;
  global $root_dir, $rating_filepath, $use_flock;

  $db_ratingloaded=1;
  $datname = $rating_filepath;
 
  if(!file_exists($datname)) return;

  $fh=fopen($datname,"rt");
	if ($use_flock) flock($fh,LOCK_SH);

  while(!feof($fh)) {
      $line=fgets($fh,4096);
      if(!$line) continue;
      $a=explode("|",$line);
      $db_ratingdata[$a[0]][0]+=$a[2];
      $db_ratingdata[$a[0]][1]++;
      $db_ratingip[$a[1]][$a[0]]=1;
      }

  fclose($fh);
  return 1;
}

function get_rating_data($name) {
  global $db_ratingdata,$db_ratingloaded,$db_ratingip;
  global $root_dir;
  if(!$db_ratingloaded) load_rating_data();
  return $db_ratingdata[$name];
}

function get_comment($nom)
{
  $data=get_picture_data($nom);
  if(!$data) return "";
  return unquote_smart($data[1]);
}

function get_rating($nom)
{
  $data=get_rating_data($nom);
  if(!$data) return false;
  return $data[0]/$data[1];
}

function already_rated($nom)
{
  global $db_ratingdata,$db_ratingloaded,$db_ratingip;
  global $root_dir;
  if(!$db_ratingloaded) load_rating_data();
  if($db_ratingip[getenv("REMOTE_ADDR")][stripslashes($nom)]) return 1;
  return 0;
}

function get_level_db($nom)
{
//  echo "getlev: $nom<br>";
  $data=get_picture_data($nom);
  if(!$data) return 0;
  return $data[2];
}

function load_user_comments_data($datname) {
  
	global $db_comdata,$db_nbcomdata,$db_datloaded;
	global $use_flock;

	if(!file_exists($datname)) return;

	$fh=fopen($datname,"rt");
	if ($use_flock) flock($fh,LOCK_SH);

  while(!feof($fh)) {
      $line=fgets($fh,4096);
      if(!$line) continue;
      $a=explode("|",$line);
      $i=(int)($db_nbcomdata[$a[0]]++);
      $db_comdata[$a[0]][$i][0]=unquote_smart($a[3]);
      $db_comdata[$a[0]][$i][1]=$a[2];
      $db_comdata[$a[0]][$i][2]=unquote_smart($a[1]);
      $db_comdata[$a[0]][$i][3]=$a[4];
      $db_comdata[$a[0]][$i][4]=$i+1;
      }

  fclose($fh);
  $db_datloaded[$datname]=1;
  return 1;
}

function get_nb_comments($name)
{
  global $db_comdata,$db_nbcomdata,$db_datloaded;
  global $root_dir;
  $datname=$root_dir.dirname($name)."/.thumbs/comments.dat";
  if(!$db_datloaded[$datname]) 
    if(!load_user_comments_data($datname)) return 0;
  return (int)$db_nbcomdata[$name];
}

function get_user_comments($name) {
  global $db_comdata,$db_nbcomdata,$db_datloaded;
  global $root_dir;
  $datname=$root_dir.dirname($name)."/.thumbs/comments.dat";
  if(!$db_datloaded[$datname]) 
    if(!load_user_comments_data($datname)) return $emptyarray;
  return $db_comdata[$name];
}

function get_last_commented($dir = "/",$nb_last_commented = 15, $seclevel = 0)
{

    // Rewrite of get_last_user_comments with 2 more arguments: seclevel and nb_last_commented
    // With those changes, we won't have to worry during the display phase

    global $root_dir, $comments_filepath, $use_flock;

    if (!$dir) $dir="/";

    $dir=stripcslashes($dir);
    $datname=$comments_filepath;
    if(!file_exists($datname)) return $emptyarray;
    $fh=fopen($datname,"rt");
    $i=0;
    if ($use_flock) flock($fh,LOCK_SH);

    while(!feof($fh)) {

        $line=fgets($fh,4096);
        if(!$line) continue;
        $a=explode("|",$line);

        if (strstr(dirname($a[0]).'/',$dir) 
        && is_readable($root_dir."/".stripcslashes($a[0]))
        && get_level($a[0])<=(int)$seclevel) 
            $ret[]=$a;

    }

    fclose($fh);

    // If no result, return n0w !
    if (!$ret) return;

    // Sorting result to have picture only once

    // Revert the array to have the most recents pictures at the beginning
    $ret=array_reverse($ret);

    $ret2=array();
    if (sizeof($ret) < $nb_last_commented) $nb_last_commented = sizeof($ret);

    // Remove duplicate pictures and keep only the latest comment
    foreach ($ret as $data) {

        if (!array_search_r($data[0],$ret2)) $ret2[]=$data;

    }

    // Keep only the $nb_last_commented
    $ret2=array_slice($ret2, 0, $nb_last_commented);

    return $ret2;

}

function array_search_r($needle, $haystack){
  foreach($haystack as $value) {
    if(is_array($value)) $match=array_search_r($needle, $value);
    if($value==$needle) $match=1;
    if($match) return 1;
  }
return 0;
}

function tr_cmp($a,$b) {
  if($a[1]==$b[1]) return 0;
  return ($a[1]<$b[1])?1:-1;
}

function get_top_ratings($dir = "/", $nb_top_rating = 10, $seclevel = 0) {

  global $db_ratingdata,$db_ratingloaded;
  global $root_dir;
  
  if(!$db_ratingloaded) load_rating_data();

  if (!$db_ratingdata) return;

  reset($db_ratingdata);
  $i=0;
  foreach ($db_ratingdata as $key => $val) {
    if (strstr(dirname($key).'/',$dir) && is_readable($root_dir."/".stripcslashes($key)) && get_level($key)<=(int)$seclevel) { 
      $ret[$i][0]=$key;
      $ret[$i][1]=$val[0]/$val[1];
      $i++;
      }
  }
  usort($ret,"tr_cmp");
  
  // Limit the number of entries (We must do this at the end because of avg rating calcul)
  $ret=array_slice($ret,0,$nb_top_rating);
  return $ret;
}

function db_add_rating($display,$rating)
{

    global $db_ratingloaded,$db_ratingdata;
    global $rating_filepath, $use_flock;

    $datname = $rating_filepath;

    // Checking value of rating (must be between 0 and 10)
    if (!is_numeric($rating) || $rating < 1 || $rating > 10) {
        trigger_error("Rating value should be between 1 and 10", E_USER_WARNING);
        return false;
    }
    
    if (is_file($datname) && !is_writable($datname)) {
        trigger_error("Unable to open the users file, please check permissions for users.dat", ERROR);
        return false; 
    }

    $fh=fopen($datname,"a+");
    if ($use_flock) flock($fh,LOCK_EX);
    fseek($fh,0,SEEK_END);
    fwrite($fh,stripslashes($display)."|".getenv("REMOTE_ADDR")."|".quote_smart($rating)."\n");
    fclose($fh);

    $db_ratingloaded=0;
    unset($db_ratingdata);

    return true;
}

function db_add_user_comment($picname,$comment,$user) {

  global $db_comdata,$db_nbcomdata,$db_datloaded;
  global $root_dir,$comments_filepath, $use_flock;

  $datname=$root_dir.dirname($picname)."/.thumbs/comments.dat";
	if (is_file($datname) && !is_writable($datname)) {
		trigger_error("FAILED to write to $datname, check permissions of the file", WARNING);
		return; 
		}

  $fh=fopen($datname,"a+");
  if ($use_flock) flock($fh,LOCK_EX);
  fseek($fh,0,SEEK_END);
  fwrite($fh,$picname."|".quote_smart($comment)."|".date("Y-m-d H:i:s")."|".quote_smart($user)."|".getenv("REMOTE_ADDR")."\n");
  fclose($fh);

  unset($db_datloaded[$datname]);

  $datname=$comments_filepath;
	if (is_file($datname) && !is_writable($datname)) {
		trigger_error("FAILED to write to $datname, check permissions of the file", WARNING);
		return;
		}

  $fh=fopen($datname,"a+");
  if ($use_flock) flock($fh,LOCK_EX);
  fseek($fh,0,SEEK_END);
  fwrite($fh,$picname."|".date("Y-m-d H:i:s")."|".quote_smart($user)."\n");
  fclose($fh);

}

function db_is_login_ok($user,$pass)
{
    global $users_filepath;

    $datname = $users_filepath;

    if (!is_readable($datname)) {
        trigger_error("DEBUG: Unable to open ".$datname, DEBUG);
        return false;
    }


    $fh=fopen($datname,"rt");

    while(!feof($fh)) {
        $line=fgets($fh,4096);
        if(!$line) continue;
        $a=explode("|",$line);
        if($a[0]==$user && $a[1]==$pass) {
            $a["login"]=$a[0];
            $a["seclevel"]=$a[3];
            $a["cookieval"]=$a[2];
            fclose($fh);
            return $a;
        }

    }

    fclose($fh);
    return $emptyarray;
}

function db_get_login($LoginValue)
{

    global $users_filepath;

    $datname = $users_filepath;

    if (!is_readable($datname)) {
        trigger_error("Unable to open the users file, please check permissions for users.dat", ERROR);
        return false;
    }

    $fh=fopen($datname,"rt");
    while(!feof($fh)) {
        $line=fgets($fh,4096);
        if(!$line) continue;
        $a=explode("|",$line);
        if($a[2]==$LoginValue) {
            $a["login"]=$a[0];
            $a["seclevel"]=$a[3];
            $a["cookieval"]=$a[2];
            fclose($fh);
            return $a;
        }
    }

    fclose($fh);
    return $emptyarray;
}

function db_update_pic($display,$dsc,$lev) {

	global $db_picdata,$db_datloaded;
  global $root_dir, $use_flock; $debug_mode;

  $display=stripslashes($display);
  $datname=$root_dir.dirname($display)."/.thumbs/pictures.dat";

	if (!is_readable(dirname($datname))) {
		 if (!@mkdir(dirname($datname))) {
			   $error_msg="Unable to create ".dirname($datname).", check permissions of the parent directory";
			   cust_error_handler($error_msg, 1);
				 if ($debug_mode >= 2) 
					   cust_error_handler(basename(__FILE__).":line(".__LINE__.") $error_msg", 1, 1);
				 return false;
				 }
	   }

	if (is_file($datname) && !is_writable($datname)) {
		$error_msg="File $datname is not writable, check permissions of the file";
		cust_error_handler($error_msg, 5);
	  if ($debug_mode >= 2) 
			 cust_error_handler(basename(__FILE__).":line(".__LINE__.") $error_msg", 1, 1);
		return false; 
		}

	$fh=fopen($datname,"a+");

	if ($use_flock) {
		 if (!flock($fh,LOCK_EX)) {
			  $error_msg="Unable to obtain LOCK on $datname";
				cust_error_handler($error_msg, 1);
	      if ($debug_mode >= 2) 
			     cust_error_handler(basename(__FILE__).":line(".__LINE__.") $error_msg", 1, 1);
		    }
	   }

  if (!rewind($fh)) {
		 $error_msg="Unable to SEEK on $datname";
		 cust_error_handler($error_msg, 5);
	   if ($debug_mode >= 2) 
			  cust_error_handler(basename(__FILE__).":line(".__LINE__.") $error_msg", 1, 1);
		 return false;
	   }

    $i=0;
    while(!feof($fh)) {
      $line=fgets($fh,4096);
      if(!$line) continue;
      $a=explode("|",$line);
      if($a[0]!=$display) $comm[$i++]=$line;
      } 
		if (!ftruncate($fh,0)) {
			 $error_msg="Unable to TRUNCATE $datname";
			 cust_error_handler($error_msg, 5);
	     if ($debug_mode >= 2) 
			    cust_error_handler(basename(__FILE__).":line(".__LINE__.") $error_msg", 1, 1);
		   }
    for ($i=0;$i<sizeof($comm);$i++)
			  fwrite($fh,$comm[$i]);

    if (!fwrite($fh,$display."|".quote_smart($dsc)."|".quote_smart($lev)."\n")) {
			  $error_msg="Unable to WRITE in $datname";
			  cust_error_handler($error_msg, 5);;
	      if ($debug_mode >= 2) 
			      cust_error_handler(basename(__FILE__).":line(".__LINE__.") $error_msg", 1, 1);
		    }
  
  fclose($fh);
  $db_datloaded[$datname]=0;
	return true;
}

function db_delete_pic($display) {

  global $db_picdata,$db_datloaded;
  global $root_dir, $use_flock;

  $display=stripslashes($display);
  $datname=$root_dir.dirname($display)."/.thumbs/pictures.dat";

  if (!is_file($datname)) return true;

  if (!is_writable($datname)) {
     cust_error_handler("Unable to write to $datname, check permissions of the file", 1);
     return false; 
     }

  $fh=fopen($datname,"a+");

	if ($use_flock) {
		 if(!flock($fh,LOCK_EX)) cust_error_handler("Unable to obtain LOCK on $datname", 1);
	   }

  if (!rewind($fh)) {
		 cust_error_handler("Unable to SEEK on $datname", 5);
		 return false;
	   }

    $i=0;
    while(!feof($fh)) {
      $line=fgets($fh,4096);
      if(!$line) continue;
      $a=explode("|",$line);
      if($a[0]!=$display) $comm[$i++]=$line;
     }
    ftruncate($fh,0);
    for($i=0;$i<sizeof($comm);$i++)
      fwrite($fh,$comm[$i]);

	fclose($fh);

// Now deleting comments
db_del_user_comment($display,"all");

}

function db_del_user_comment($pic,$delcom) {
  global $db_comdata,$db_nbcomdata,$db_datloaded;
  global $root_dir, $comments_filepath, $use_flock;

// If delcom is equal to "all" then will delete all matching comments

  $datname=$root_dir.dirname($pic)."/.thumbs/comments.dat";
	if (is_file($datname) && !is_writable($datname)) {
		cust_error_handler("Unable to write to $datname, check permissions of the file", 1);
		return false; 
		}

  $fh=fopen($datname,"a+");
	if ($use_flock) {
		 if(!flock($fh,LOCK_EX)) cust_error_handler("Unable to obtain LOCK on $datname", 1);
	   }

  if (!rewind($fh)) {
		 cust_error_handler("Unable to SEEK on $datname", 5);
		 return false;
	   }

    $i=0; $j=0;
    while(!feof($fh)) {
      $line=fgets($fh,4096);
      if(!$line) continue;
      $a=explode("|",$line);
      if($a[0]==$pic) {
        if($j==(($delcom)-1) || $delcom == "all") { $todel=$a; }
        else $comm[$i++]=$line;
        $j++;
      } else $comm[$i++]=$line;
    }
    ftruncate($fh,0);
    for($i=0;$i<sizeof($comm);$i++)
      fwrite($fh,$comm[$i]);

  fclose($fh);
  $db_datloaded[$datname]=0;
  if($todel || $delcom == "all") {
    unset($comm);
    // update last user comments file
    $datname=$comments_filepath;
		if (is_file($datname) && !is_writable($datname)) {
			cust_error_handler("Unable to write to $datname, check permissions of the file", 1);
			return false;
			}
    $fh=fopen($datname,"a+");
	if ($use_flock) {
		 if(!flock($fh,LOCK_EX)) cust_error_handler("Unable to obtain LOCK on $datname", 1);
	   }

  if (!rewind($fh)) {
		 cust_error_handler("Unable to SEEK on $datname", 5);
		 return false;
	   }

    $i=0;
    while(!feof($fh)) {
        $line=fgets($fh,4096);
        if(!$line) continue;
        $a=explode("|",$line);
        if($a[0]==$pic && ($a[1]==$todel[2] || $delcom == "all")) { }
        else $comm[$i++]=$line;
      }
      ftruncate($fh,0);
      for($i=0;$i<sizeof($comm);$i++)
        fwrite($fh,$comm[$i]);

		fclose($fh);
  }
}

// User management

function get_all_user_information()
{
    global $users_filepath;

    if (!is_readable($users_filepath)) {
        trigger_error("DEBUG: Unable to open ".$users_filepath, DEBUG);
        return false;
    }

    $users = file($users_filepath);

    foreach($users as $value) {
        list($login, $passwd, $cki, $sec_lvl) = explode('|',$value);
        $allLoginPassword[] = array('login'=>trim($login), 'password'=>trim($passwd), 'security_level'=>trim($sec_lvl), 'cookie_value'=>trim($cki));
    }

    return $allLoginPassword;
}

function delete_user($uid) {

    $all_user_info = get_all_user_information();

    if(isSet($all_user_info[$uid])) {
        unset($all_user_info[$uid]);
        save_user_information($all_user_info);
    }
}

function save_user_information($all_user_info)
{
	global $use_flock;
    global $users_filepath;

    $data = '';
    foreach($all_user_info as $line) {
        $data .= quote_smart($line['login']).'|'.quote_smart($line['password']).'|'.quote_smart($line['cookie_value']).'|'.quote_smart($line['security_level'])."\n";
    }

	if ($use_flock && file_exists($users_filepath)) flock($fh,LOCK_SH);
    $fd = fopen($users_filepath,'w');
    fwrite($fd, $data);
    fclose($fd);
}
?>
