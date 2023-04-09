<?php
/*
#===========================================================================
#= Project: PluggedOut Blog
#= File   : lib/database.php
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


// Description : Connects to the database
function db_connect(){
	
	global $db_server;
	global $db_name;
	global $db_username;
	global $db_password;
	
	$con = mysql_connect($db_server,$db_username,$db_password);
	if (!(mysql_select_db($db_name,$con))){
		// cannot find database
		
	}
	//print "<li>Connected ".$con;
	return $con;
}

function db_disconnect($con){
	mysql_close($con);
	//print "<li>Closed ".$con;
}

function db_sql_entries_default($limit){
	global $db_prefix;
	
	$sql = "SELECT DISTINCT ent.nEntryId,ent.cTitle,ent.cBody,ent.dAdded,ent.dEdited,ent.nUserAdded,ausr.cUsername AS cUserAdded,ent.nUserEdited,eusr.cUsername AS cUserEdited,ent.nComments"
		." FROM ".$db_prefix."entries ent"
		." INNER JOIN ".$db_prefix."users ausr ON ent.nUserAdded=ausr.nUserId"
		." INNER JOIN ".$db_prefix."users eusr ON ent.nUserEdited=eusr.nUserId"
		." WHERE ent.cStatus='P'"
		." ORDER BY ent.dAdded DESC"
		." LIMIT ".$limit;
		
	return $sql;
}

// Description : Creates SQL to retrieve all entries within a particular day, month and year
function db_sql_entries_day($year,$month,$day){
	global $db_prefix;
	$sql = "SELECT DISTINCT ent.nEntryId,ent.cTitle,ent.cBody,ent.dAdded,ent.dEdited,ent.nUserAdded,ausr.cUsername AS cUserAdded,ent.nUserEdited,eusr.cUsername AS cUserEdited,ent.nComments"
		." FROM ".$db_prefix."entries ent"
		." INNER JOIN ".$db_prefix."users ausr ON ent.nUserAdded=ausr.nUserId"
		." INNER JOIN ".$db_prefix."users eusr ON ent.nUserEdited=eusr.nUserId"
		." WHERE MONTH(ent.dAdded)=".$month." AND YEAR(ent.dAdded)=".$year." AND DAYOFMONTH(ent.dAdded)=".$day
		." AND ent.cStatus='P'"
		." ORDER BY ent.nEntryId DESC";
	return $sql;
}


// Description : Creates SQL to retrieve all entries within a particular month and year
function db_sql_entries_month($year,$month){
	global $db_prefix;
	$sql = "SELECT DISTINCT ent.nEntryId,ent.cTitle,ent.cBody,ent.dAdded,ent.dEdited,ent.nUserAdded,ausr.cUsername AS cUserAdded,ent.nUserEdited,eusr.cUsername AS cUserEdited,ent.nComments"
		." FROM ".$db_prefix."entries ent"
		." INNER JOIN ".$db_prefix."users ausr ON ent.nUserAdded=ausr.nUserId"
		." INNER JOIN ".$db_prefix."users eusr ON ent.nUserEdited=eusr.nUserId"
		." WHERE MONTH(ent.dAdded)=".$month." AND YEAR(ent.dAdded)=".$year
		." AND ent.cStatus='P'"
		." ORDER BY ent.nEntryId DESC";
	return $sql;
}


// Description : Creates SQL to retrieve all entries with search terms in their title or body
function db_sql_entries_search($keywords){
	global $db_prefix;
	$keywords = mysql_escape_string($keywords);
	$sql = "SELECT DISTINCT ent.nEntryId,ent.cTitle,ent.cBody,ent.dAdded,ent.dEdited,ent.nUserAdded,ausr.cUsername AS cUserAdded,ent.nUserEdited,eusr.cUsername AS cUserEdited,ent.nComments"
		." FROM ".$db_prefix."entries ent"
		." INNER JOIN ".$db_prefix."users ausr ON ent.nUserAdded=ausr.nUserId"
		." INNER JOIN ".$db_prefix."users eusr ON ent.nUserEdited=eusr.nUserId"
		." WHERE ent.cTitle LIKE '%".$keywords."%' OR ent.cBody LIKE '%".$keywords."%'"
		." AND ent.cStatus='P'";

	return $sql;
}


// Description : Creates SQL to retrieve all entries of a particular category
function db_sql_entries_category($categoryid){
	global $db_prefix;
	$sql = "SELECT DISTINCT ent.nEntryId,ent.cTitle,ent.cBody,ent.dAdded,ent.dEdited,ent.nUserAdded,ausr.cUsername AS cUserAdded,ent.nUserEdited,eusr.cUsername AS cUserEdited"
		." FROM ".$db_prefix."entries ent"
		." INNER JOIN ".$db_prefix."users ausr ON ent.nUserAdded=ausr.nUserId"
		." INNER JOIN ".$db_prefix."users eusr ON ent.nUserEdited=eusr.nUserId"
		." LEFT OUTER JOIN ".$db_prefix."entry_categories entcat ON ent.nEntryId=entcat.nEntryId"
		." WHERE entcat.nCategoryId=".$categoryid
		." AND ent.cStatus='P'";
		
	return $sql;
}


// Description : Creates SQL to retrieve a particular entry
function db_sql_entries_entry($entryid){
	global $db_prefix;
	$sql = "SELECT DISTINCT ent.nEntryId,ent.cTitle,ent.cBody,ent.dAdded,ent.dEdited,ent.nUserAdded,ausr.cUsername AS cUserAdded,ent.nUserEdited,eusr.cUsername AS cUserEdited, ent.nComments"
		." FROM ".$db_prefix."entries ent"
		." INNER JOIN ".$db_prefix."users ausr ON ent.nUserAdded=ausr.nUserId"
		." INNER JOIN ".$db_prefix."users eusr ON ent.nUserEdited=eusr.nUserId"
		." WHERE ent.nEntryId=".$entryid;
	return $sql;
}


// Description : Creates SQL to retrieve a list of categories for a particular entry
function db_sql_entry_categories($entryid){
	global $db_prefix;
	$sql = "SELECT cat.nCategoryId,cat.cCategoryName"
		." FROM ".$db_prefix."entry_categories entcat"
		." INNER JOIN ".$db_prefix."categories cat ON entcat.nCategoryId=cat.nCategoryId"
		." WHERE entcat.nEntryId=".$entryid;
	return $sql;
}


// Description : Creates SQL to retrieve the comments for a particular entry
function db_sql_comments($entryid=""){
	global $db_prefix;
	if ($entryid!=""){
		$sql = "SELECT *"
			." FROM ".$db_prefix."comments com"
			." WHERE com.nEntryId=".$entryid
			." ORDER BY com.nCommentId DESC";
	} else {
		$sql = "";
	}
	return $sql;
}


// Description : Creates SQL to retrieve a list of all the categories
function db_sql_categorylist(){
	global $db_prefix;
	$sql = "SELECT cat.nCategoryId,cat.cCategoryName,COUNT(entcat.nEntryId) AS nCount"
		." FROM ".$db_prefix."categories cat"
		." INNER JOIN ".$db_prefix."entry_categories entcat ON cat.nCategoryId=entcat.nCategoryId"
		." GROUP BY cat.nCategoryId,cat.cCategoryName"
		." ORDER BY cat.cCategoryName";
	return $sql;
}


function db_sql_calendar_counts($year,$month){
	global $db_prefix;
	$sql = "SELECT DAYOFMONTH(ent.dAdded) AS nDay,COUNT(*) AS nCount FROM ".$db_prefix."entries ent"
		." WHERE YEAR(ent.dAdded)=".$year." AND MONTH(ent.dAdded)=".$month
		." AND ent.cStatus='P'"
		." GROUP BY DAYOFMONTH(ent.dAdded)";
	return $sql;
}


// Description : Changes a SQL date into an array of elements
// Arguments   : date - formatted as YYYY-MM-DD HH-MM-SS
// Returns     : Array holding date parameters (see getdate function in PHP docs)
function db_datetoarray($date){
	$year = substr($view_rows[$i]["dEntryDate"],0,4);
	$month = substr($view_rows[$i]["dEntryDate"],5,2);
	$day = substr($view_rows[$i]["dEntryDate"],8,2);
	$hours = substr($view_rows[$i]["dEntryDate"],11,2);
	$minutes = substr($view_rows[$i]["dEntryDate"],14,2);
	$seconds = substr($view_rows[$i]["dEntryDate"],17,2);
	
	$adate = getdate(mktime($hour,$minute,$second,$month,$day,$year));
	
	return $adate;
}


// Description : Creates SQL to add a comment
function db_sql_comment_add($entryid,$name,$email,$url,$comment){
	
	global $db_prefix;
	
	// prepare data
	$name = mysql_escape_string(strip_tags($name));
	$email = mysql_escape_string(strip_tags($email));
	$url = mysql_escape_string(strip_tags($url));
	$comment = mysql_escape_string(strip_tags($comment));
	
	// create SQL
	$sql = "INSERT INTO ".$db_prefix."comments (nEntryId,cName,cEMail,cURL,cComment,dAdded)"
		." VALUES (".$entryid.",'".$name."','".$email."','".$url."','".$comment."',now())";
	
	return $sql;
}

function db_sql_entry_comments_update($entryid){
	global $db_prefix;
	$sql = "UPDATE ".$db_prefix."entries SET nComments=nComments+1 WHERE nEntryId=".$entryid;
	return $sql;
}

// Description : Lists the categories filed against an entry
function db_sql_entry_categorylist($entryid){
	global $db_prefix;
	$sql = "SELECT DISTINCT entcat.nCategoryId,cat.cCategoryName FROM ".$db_prefix."entry_categories entcat"
		." INNER JOIN ".$db_prefix."categories cat ON entcat.nCategoryId=cat.nCategoryId"
		." WHERE entcat.nEntryId=".$entryid;
	return $sql;
}

?>