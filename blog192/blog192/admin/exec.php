<?php
/*
#===========================================================================
#= Project: PluggedOut Blog
#= File   : admin/exec.php
#= Version: 1.9.2 (2005-09-13)
#= Author : Jonathan Beckett
#= Email  : jonbeckett@pluggedout.com
#= Website: http://www.pluggedout.com/index.php?pk=dev_blog
#= Support: http://www.pluggedout.com/development/forums/viewforum.php?f=26
#===========================================================================
#= Copyright (c) 2005 Jonathan Beckett
#= You are free to use and modify this script as long as this header
#= section stays intact. This file is part of PluggedOut Blog.
#=
#= This program is free software; you can redistribute it and/or modify
#= it under the terms of the GNU General Public License as published by
#= the Free Software Foundation; either version 2 of the License, or
#= (at your option) any later version.
#=
#= This program is distributed in the hope that it will be useful,
#= but WITHOUT ANY WARRANTY; without even the implied warranty of
#= MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#= GNU General Public License for more details.
#=
#= You should have received a copy of the GNU General Public License
#= along with CMS files; if not, write to the Free Software
#= Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#===========================================================================
*/

require "../lib/session.php";
require "../lib/config.php";
require "../lib/database.php";
require "../lib/misc.php";

// Description : Handles a login attempt
// Arguments   : username - the user name
//               password - the user password
// Returns     : true / false
// Last Change : 2005-07-13
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function user_login($username,$password){
	
	global $db_prefix;
	
	$crypt_salt = get_setting("crypt_salt");
	
	$con = db_connect();
	
	$username = mysql_escape_string($username);
	$password = mysql_escape_string(crypt($password,$crypt_salt));
	
	$sql = "SELECT * FROM ".$db_prefix."users WHERE cUsername='".$username."' AND cPassword='".$password."'";
	$result = mysql_query($sql,$con);
	if ($result!=false){
		if (mysql_num_rows($result)>0){
			
			// user found
			$row = mysql_fetch_array($result);
			
			// initialise session variables
			$_SESSION["blog_userid"]=$row["nUserId"];
			$_SESSION["blog_username"]=stripslashes($row["cUsername"]);
			
			// put the session variables into cookies
			setcookie("blog_userid",$_SESSION["blog_userid"]);
			setcookie("blog_username",$_SESSION["blog_username"]);
			
			$login_result = true;
			
		} else {
		
			// user not found
			
			// unset the session variables (redundant, but we do it anyway)
			unset($_SESSION["blog_userid"]);
			unset($_SESSION["blog_username"]);
			
			$login_result = false;
		}
	} else {
		report_problem(1,"user_login ".$sql);
	}
	
	db_disconnect($con);
	
	return $login_result;
}


// Description : Logs the user out of the admin interface
// Arguments   : None
// Returns     : True / False
// Last Change : 2005-07-13
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function user_logout(){
	
	if (isset($_SESSION["blog_userid"])){

		// destroy cookies (blank them, and set to exire in the past)
		setcookie ("blog_userid", "", time() - 3600);
		setcookie ("blog_username", "", time() - 3600);

		// destroy session variables
		unset($_SESSION["blog_userid"]);
		unset($_SESSION["blog_username"]);

		return true;
		
	} else {
		header("Location: index.php");
	}
}


function theme_set($theme){
	if (isset($_SESSION["blog_userid"])){

		$result = set_setting("theme",$theme);
		return $result;
	
	} else {
		header("Location: index.php");
	}
}

function user_add(){
	
	if (isset($_SESSION["blog_userid"])){

		global $db_prefix;

		// default the result
		$result = true;

		// username and password are mandatory
		if (isset($_REQUEST["username"]) && isset($_REQUEST["password"])){

			$username = mysql_escape_string(strip_tags($_REQUEST["username"]));
			$password = mysql_escape_string(crypt(strip_tags($_REQUEST["password"]),get_setting("crypt_salt")));
			$email = mysql_escape_string(strip_tags($_REQUEST["email"]));
			$role = mysql_escape_string($_REQUEST["role"]);

			$sql = "INSERT INTO ".$db_prefix."users (cUsername,cPassword,cEMail,cRole)"
				." VALUES ("
				."'".$username."'"
				.",'".$password."'"
				.",'".$email."'"
				.",'".$role."'"
				.")";

			$con = db_connect();
			$result = mysql_query($sql,$con);
			db_disconnect($con);

			if ($result!=false){
				$result = true;
			}
		}

		return $result;
		
	} else {
		header("Location: index.php");
	}
}


function user_edit(){

	if (isset($_SESSION["blog_userid"])){

		global $db_prefix;

		// default the result
		$result = true;

		// entryid and username are mandatory
		if (isset($_REQUEST["userid"]) && isset($_REQUEST["username"])){

			$username = mysql_escape_string($_REQUEST["username"]);
			$email = mysql_escape_string($_REQUEST["email"]);
			$role = mysql_escape_string($_REQUEST["role"]);

			$con = db_connect();

			$sql = "UPDATE ".$db_prefix."users SET"
				." cUsername='".$username."'"
				.",cEMail='".$email."'"
				.",cRole='".$role."'"
				." WHERE nUserId=".$_REQUEST["userid"];

			$result = mysql_query($sql,$con);

			if ($result!=false){

				if (isset($_REQUEST["user_password"])){
					if ($_REQUEST["user_password"]!=""){
						$password = mysql_escape_string(crypt($_REQUEST["user_password"],get_setting("crypt_salt")));
						$sql = "UPDATE ".$db_prefix."users SET cPassword='".$password."' WHERE nUserId=".$_REQUEST["userid"];
						$con = db_connect();
						$result = mysql_query($sql,$con);
					}
				}

			} else {
				// problem with SQL
			}

			// make sure the result gives back true if it is not false
			// (php uses loose typing to hold more than one datatype in results sometimes)
			if ($result!=false){
				$result = true;
			}

			db_disconnect($con);

		} else {
			// problem
		}

		return $result;
	
	} else {
		header("Location: index.php");
	}
	
}

function user_remove(){
	
	if (isset($_SESSION["blog_userid"])){

		global $db_prefix;

		$result = true;

		if (isset($_REQUEST["userid"]) && isset($_REQUEST["replaceid"])){

			$con = db_connect();

			// rewrite the nUserAdded and nUserEdited fields in Entry records
			$sql = "UPDATE ".$db_prefix."entries SET nUserAdded=".$_REQUEST["replaceid"].",nUserEdited=".$_REQUEST["replaceid"];
			$result = mysql_query($sql,$con);

			// remove the user record
			$sql = "DELETE FROM ".$db_prefix."users WHERE nUserId=".$_REQUEST["userid"];
			$result = mysql_query($sql,$con);

			db_disconnect($con);
		}

		return $result;

	} else {
		header("Location: index.php");
	}
}


function entry_add(){

	if ($_SESSION["blog_userid"]!=""){
		
		global $db_prefix;
		
		if (isset($_REQUEST["title"]) && isset($_REQUEST["body"]) && isset($_REQUEST["dateadded"])){
		
			$con = db_connect();
		
			$title = mysql_escape_string($_REQUEST["title"]);
			$body = mysql_escape_string($_REQUEST["body"]);
			$date_added = $_REQUEST["dateadded"];
			
			// needs to be set according to user type
			$role = get_user_role($_SESSION["blog_userid"]);
			if ($role!="contributor"){
				$status = $_REQUEST["status"];
			} else {
				$status = "U";
			}
			
			// prepare data for basic entry insert
			$sql = "INSERT INTO ".$db_prefix."entries (cTitle,dAdded,dEdited,cBody,cStatus,nUserAdded,nUserEdited)"
				." VALUES ("
				."'".$title."'"
				.",'".$date_added."'"
				.",now()"
				.",'".$body."'"
				.",'".$status."'"
				.",".$_SESSION["blog_userid"]
				.",".$_SESSION["blog_userid"]
				.")";
			
			$result = mysql_query($sql,$con);
			if ($result!=false){
			} else {
				//print $sql;
			}
			
			$entryid = mysql_insert_id();
			
			// prepare category entries
			$cat_count = $_REQUEST["catcount"];
			for($i=0;$i<=$cat_count;$i++){
				if ($_REQUEST["cat".$i]!=""){
					$sql = "INSERT INTO ".$db_prefix."entry_categories (nEntryId,nCategoryId) VALUES (".$entryid.",".$i.")";
					$result = mysql_query($sql,$con);
				}
			}
			
			db_disconnect($con);
			
		} else {
			// missing information
			header("Location: problem.php");
		}
		
		return $result;
		
	} else {
		header("Location: index.php");
	}
}


function entry_edit(){

	if ($_SESSION["blog_userid"]!=""){
		
		global $db_prefix;
		
		$result = true;
				
		if (isset($_REQUEST["entryid"])){

			$con = db_connect();

			$entryid = $_REQUEST["entryid"];

			$title = mysql_escape_string($_REQUEST["title"]);
			$body = mysql_escape_string($_REQUEST["body"]);
			$dateadded = mysql_escape_string($_REQUEST["dateadded"]);

			$role = get_user_role($_SESSION["blog_userid"]);
			if ($role!="contributor"){
				$status = $_REQUEST["status"];
			} else {
				$status = "U";
			}
			
			// make changes to the entry
			$sql = "UPDATE ".$db_prefix."entries SET"
				." cTitle='".$title."'"
				.",dAdded='".$dateadded."'"
				.",cStatus='".$status."'"
				.",dEdited=now()"
				.",nUserEdited=".$_SESSION["blog_userid"]
				.",cBody='".$body."'"
				." WHERE nEntryid=".$entryid;
			
			$result = mysql_query($sql,$con);
			
			if ($result!=false){
			
				// remove category records
				$sql = "DELETE FROM ".$db_prefix."entry_categories WHERE nEntryId=".$entryid;
				$result = mysql_query($sql,$con);
			
				// insert new category records
				$cat_count = $_REQUEST["catcount"];
				for($i=0;$i<=$cat_count;$i++){
					if ($_REQUEST["cat".$i]!=""){
						$sql = "INSERT INTO ".$db_prefix."entry_categories (nEntryId,nCategoryId) VALUES (".$entryid.",".$i.")";
						$result = mysql_query($sql,$con);
					}
				}
			} else {
				print "problem with sql<br>".$sql;
			}
			
			db_disconnect($con);
		
		} else {
			$result = false;
		}
		
		return $result;
		
	} else {
		header("Location: index.php");
	}
}


function entry_remove(){

	if ($_SESSION["blog_userid"]!=""){
		
		global $db_prefix;
		
		if (isset($_REQUEST["entryid"])){
			$entryid = $_REQUEST["entryid"];
			
			$con = db_connect();
			
			$sql = "DELETE FROM ".$db_prefix."entries WHERE nEntryId=".$entryid;
			
			$result = mysql_query($sql,$con);
			
			if ($result!=false){
				$result = true;
			}
			
			db_disconnect($con);
			
		}
		
		return $result;
		
	} else {
		header("Location: index.php");
	}
}


function entry_publish(){

	if ($_SESSION["blog_userid"]!=""){
		
		global $db_prefix;
		
		if (isset($_REQUEST["entryid"])){
			$entryid = $_REQUEST["entryid"];
			
			$con = db_connect();
			
			$sql = "UPDATE ".$db_prefix."entries SET cStatus='P' WHERE nEntryId=".$entryid;
			
			$result = mysql_query($sql,$con);
			
			if ($result!=false){
				$result = true;
			}
			
			db_disconnect($con);
			
		}
		
		return $result;
		
	} else {
		header("Location: index.php");
	}
}


function entry_unpublish(){

	if ($_SESSION["blog_userid"]!=""){
		
		global $db_prefix;
		
		if (isset($_REQUEST["entryid"])){
			$entryid = $_REQUEST["entryid"];
			
			$con = db_connect();
			
			$sql = "UPDATE ".$db_prefix."entries SET cStatus='U' WHERE nEntryId=".$entryid;
			
			$result = mysql_query($sql,$con);
			
			if ($result!=false){
				$result = true;
			}
			
			db_disconnect($con);
			
		}
		
		return $result;
		
	} else {
		header("Location: index.php");
	}
}


function category_add(){
	
	if ($_SESSION["blog_userid"]!=""){
		
		global $db_prefix;
		
		$result = true;
		
		if (isset($_REQUEST["category_name"])){
			
			$con = db_connect();
			
			// first, check if the category already exists
			$sql = "SELECT * FROM ".$db_prefix."categories WHERE cCategoryName='".mysql_escape_string($_REQUEST["category_name"])."'";
			$result = mysql_query($sql,$con);
			if ($result!=false){
				$count = mysql_num_rows($result);
			} else {
				// problem
			}
			
			// if the category does not exist, add it
			if ($count==0){
				$sql = "INSERT INTO ".$db_prefix."categories (cCategoryName) VALUES ('".mysql_escape_string(strip_tags($_REQUEST["category_name"]))."')";
				$result = mysql_query($sql,$con);
			}
			
			if ($result!=false){
				$result = true;
			}
			
			db_disconnect($con);
			
		} else {
			$result = false;
		}
		
		return $result;
		
	} else {
		header("Location: index.php");
	}
}


function category_edit(){
	
	if ($_SESSION["blog_userid"]!=""){
		
		global $db_prefix;
		
		$result = true;
		
		if (isset($_REQUEST["categoryid"]) && isset($_REQUEST["category_name"])){
			
			$con = db_connect();
			
			// first, check if the category name already exists
			$sql = "SELECT * FROM ".$db_prefix."categories WHERE cCategoryName='".mysql_escape_string($_REQUEST["category_name"])."'";
			$result = mysql_query($sql,$con);
			if ($result!=false){
				$count = mysql_num_rows($result);
			} else {
				// problem
			}
			
			// if the category does not exist, add it
			if ($count==0){
				$sql = "UPDATE ".$db_prefix."categories SET cCategoryName='".mysql_escape_string(strip_tags($_REQUEST["category_name"]))."' WHERE nCategoryId=".$_REQUEST["categoryid"];
				$result = mysql_query($sql,$con);
			}
			
			if ($result!=false){
				$result = true;
			}
			
			db_disconnect($con);
			
		} else {
			$result = false;
		}
		
		return $result;
		
	} else {
		header("Location: index.php");
	}
}


function category_remove(){

	if ($_SESSION["blog_userid"]!=""){
		
		global $db_prefix;
		
		if (isset($_REQUEST["categoryid"])){
			
			$categoryid = $_REQUEST["categoryid"];
			
			$con = db_connect();
			
			$sql = "DELETE FROM ".$db_prefix."categories WHERE nCategoryId=".$categoryid;
			
			$result = mysql_query($sql,$con);
			
			if ($result!=false){
				$result = true;
			}
			
			db_disconnect($con);
			
		}
		
		return $result;
		
	} else {
		header("Location: index.php");
	}
}

function settings_edit(){

	if ($_SESSION["blog_userid"]!=""){
	
		// general settings
		$result = set_setting("theme",$_REQUEST["theme"]);
		$result = set_setting("crypt_salt",$_REQUEST["crypt_salt"]);
		$result = set_setting("results_per_page",$_REQUEST["results_per_page"]);
		$result = set_setting("default_entry_list_limit",$_REQUEST["entry_list_limit"]);
		$result = set_setting("parse_smilies",$_REQUEST["parse_smilies"]);
		
		// rss specific settings
		$result = set_setting("rss_root_url",$_REQUEST["rss_root_url"]);
		$result = set_setting("rss_title",$_REQUEST["rss_title"]);
		$result = set_setting("rss_description",$_REQUEST["rss_description"]);
		$result = set_setting("rss_language",$_REQUEST["rss_language"]);
		$result = set_setting("rss_copyright",$_REQUEST["rss_copyright"]);
		$result = set_setting("rss_editor",$_REQUEST["rss_editor"]);
		$result = set_setting("rss_webmaster",$_REQUEST["rss_webmaster"]);
		$result = set_setting("rss_category",$_REQUEST["rss_category"]);
		$result = set_setting("rss_ttl",$_REQUEST["rss_ttl"]);
	}
}

function filebrowse_file_upload(){

	ini_set("memory_limit","10M");
	ini_set("post_max_size","9M");
	ini_set("upload_max_filesize","8M");

	$uploaddir = $_GET["destination"];
	$uploadfile = $uploaddir."/".$_FILES['userfile']['name'];
	
	if (is_uploaded_file($_FILES['userfile']['tmp_name'])){
		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			// successful upload
			chmod($uploadfile, 0755);
			// sorted
			header("Location: index.php?action=file_browse&path=".$_GET["destination"]);
		} else {
			// move failed
			header("Location: index.php?action=problem");
		}
	} else {
		// upload failed
		header("Location: admin.php?action=problem");
	}
}

function filebrowse_file_delete(){

	$filename = $_GET["file"];
	if ($filename!=""){
		// get path from filename
		unlink($filename);
		header("Location: index.php?action=file_browse&path=".$_GET["path"]);
	} else {
		header("Location: index.php?action=problem");
	}
}

function filebrowse_directory_create(){
	if ($_POST["directory"]!=""){
		// check the directory name is valid
		$oldumask = umask(0);
		mkdir($_POST["path"]."/".$_POST["directory"]);
		umask($oldumask);
		chmod($_POST["path"]."/".$_POST["directory"],0777);
		header("Location: index.php?action=file_browse&path=".$_POST["path"]."/".$_POST["directory"]);
	} else {
		header("Location: index.php?action=file_browse&path=".$_POST["path"]);
	}
}

function filebrowse_directory_remove(){
	$directory = $_GET["directory"];
	if ($directory!="") {
		$result =@ rmdir($directory);
		if ($result){
			header("Location: index.php?action=file_browse&path=".$_GET["path"]);
		} else {
			header("Location: index.php?action=file_browse&path=".$_GET["path"]);
		}
	} else {
		header("Location: admin.php?action=problem");
	}
}


if (isset($_SESSION["blog_userid"])){

	
	if ($_SESSION["blog_userid"]!=""){

		$role = get_user_role($_SESSION["blog_userid"]);

		switch($_REQUEST["action"]){

			case "user_logout":
				$result = user_logout();
				if ($result){
					// logout success
					header("Location: index.php");
				} else {
					// logout failure
					header("Location: index.php");
				}
				break;

			case "theme_set":
				$result = theme_set($_REQUEST["theme"]);
				if ($result){
					// theme set successfully
					header("Location: index.php?action=theme_list");
				} else {
					// theme set failed
					header("Location: index.php?action=theme_list");
				}
				break;

			case "user_add":
				$result = user_add();
				if ($result){
					header("Location: index.php?action=user_list");
				} else {
					// problem
				}
				break;

			case "user_edit":
				$result = user_edit();
				if ($result){
					header("Location: index.php?action=user_list");
				} else {
					// problem
				}
				break;

			case "user_remove":
				$result = user_remove();
				if ($result){
					header("Location: index.php?action=user_list");
				} else {
					// problem
				}
				break;

			case "entry_add":
				$result = entry_add();
				header("Location: index.php?action=entry_list");
				break;

			case "entry_edit":
				$result = entry_edit();
				header("Location: index.php?action=entry_list");
				break;

			case "entry_remove":
				$result = entry_remove();
				header("Location: index.php?action=entry_list");
				break;

			case "entry_publish":
				$result = entry_publish();
				header("Location: index.php?action=entry_list");
				break;

			case "entry_unpublish":
				$result = entry_unpublish();
				header("Location: index.php?action=entry_list");
				break;

			case "category_add":
				$result = category_add();
				header("Location: index.php?action=category_list");
				break;

			case "category_edit":
				$result = category_edit();
				header("Location: index.php?action=category_list");
				break;

			case "category_remove":
				$result = category_remove();
				header("Location: index.php?action=category_list");
				break;

			case "settings_edit":
				$result = settings_edit();
				header("Location: index.php?action=settings_edit");
				break;

			case "filebrowse_file_upload":
				$result = filebrowse_file_upload();
				break;

			case "filebrowse_file_delete":
				$result = filebrowse_file_delete();
				break;

			case "filebrowse_directory_create":
				$result = filebrowse_directory_create();
				break;

			case "filebrowse_directory_remove":
				$result = filebrowse_directory_remove();
				break;

			default:
				// no action sent
				break;
		}
	
	} else {
	}
	
} else {

	// no user logged in
	switch($_REQUEST["action"]){
		case "user_login":
			$username = $_REQUEST["username"];
			$password = $_REQUEST["password"];
			$result = user_login($username,$password);
			if ($result){
				// login success
				header("Location: index.php");
			} else {
				// login failure
				header("Location: index.php?problem=login_failure");
			}
		break;
	}
}
?>