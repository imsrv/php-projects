<?php
/*
#===========================================================================
#= Project: PluggedOut Blog
#= File   : lib/misc.php
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

function set_setting($name,$value){
	
	global $db_prefix;
	
	$con = db_connect();
	
	// find out if the setting already exists
	// - update it or insert it accordingly
	$sql = "SELECT * FROM ".$db_prefix."settings WHERE cName='".mysql_escape_string($name)."'";
	$result = mysql_query($sql,$con);
	if ($result!=false){
		if (mysql_num_rows($result)>0){
			$sql = "UPDATE ".$db_prefix."settings SET cValue='".mysql_escape_string($value)."' WHERE cName='".mysql_escape_string($name)."'";
			$result = mysql_query($sql,$con);
			if ($result!=false){
				$result = "";
			} else {
				report_problem(1,"set_setting ".$sql);
			}
		} else {
			$sql = "INSERT INTO ".$db_prefix."settings (cName,cValue) VALUES ('".mysql_escape_string($name)."','".mysql_escape_string($value)."')";
			$result = mysql_query($sql,$con);
			if ($result!=false){
				$result = "";
			} else {
				report_problem(1,"set_setting ".$sql);
			}
		}
	} else {
		report_problem(1,"set_setting ".$sql);
	}
	
	db_disconnect($con);
	
	return $result;
}

function get_setting($name){
	global $db_prefix;
	$con = db_connect();
	$sql = "SELECT * FROM ".$db_prefix."settings WHERE cName='".mysql_escape_string($name)."'";
	//print " ".$sql;
	$result = mysql_query($sql,$con);
	if ($result!=false){
		if (mysql_num_rows($result)>0){
			$row = mysql_fetch_array($result);
			$value = stripslashes($row["cValue"]);
		} else {
			$value = "";
		}
	} else {
		report_problem(1,"get_setting ".$sql);
	}
	db_disconnect($con);
	return $value;
}

function get_user_role($userid){
	global $db_prefix;
	$con = db_connect();
	$sql = "SELECT cRole FROM ".$db_prefix."users WHERE nUserId=".$userid;
	$result = mysql_query($sql,$con);
	if ($result!=false){
		if (mysql_num_rows($result)>0){
			$row = mysql_fetch_array($result);
			$role = stripslashes($row["cRole"]);
		} else {
			$role = "";
		}
	} else {
		$role = "";
	}
	return $role;
}

function report_problem($id,$data=""){
	header("Location: problem.php?id=".$id."&data=".$data);
}
?>