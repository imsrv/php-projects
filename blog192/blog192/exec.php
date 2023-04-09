<?php
/*
#===========================================================================
#= Project: PluggedOut Blog
#= File   : exec.php
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

include "lib/config.php";
include "lib/database.php";
include "lib/misc.php";

function comment_add($entryid,$name="",$email="",$url="",$comment=""){
	
	$sql = db_sql_comment_add($entryid,$name,$email,$url,$comment);	
	$con = db_connect();
	
	$result = mysql_query($sql,$con);

	if ($result!=false){
		$sql = db_sql_entry_comments_update($entryid);
		$result = mysql_query($sql,$con);
		if ($result!=false){
			$result = true;
		} else {
			report_problem(1,"comment_add ".$sql);
		}
	} else {
		report_problem(1,"comment_add ".$sql);
	}

	db_disconnect($con);

	return $result;	
}


switch ($_GET["action"]){
	case "comment_add":
		$result = comment_add($_REQUEST["entryid"],$_REQUEST["name"],$_REQUEST["email"],$_REQUEST["url"],$_REQUEST["comment"]);
		$url = "index.php?entryid=".$_REQUEST["entryid"];
		break;
}

if ($result!=false){
	header("Location: ".$url);
} else {
	//report_problem(1,"Problem with Exec function");
}

?>