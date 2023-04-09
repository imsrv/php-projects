<?php
/*
#===========================================================================
#= Project: PluggedOut Blog
#= File   : admin/lib/html.php
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


// Description : Provides the default page template for the administration
//               interface - all other chunks get inserted in at the end
//               of this script.
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_page(){
	$html = "<html>\n"
		."<head>\n"
		."<title>Blog Administration</title>\n"
		."<style>\n"
		.".banner_title {font-family:Verdana,Arial,Helvetica;font-size:13px;line-height:22px;font-weight:bold;}\n"
		.".banner_smallprint {font-family:Verdana,Arial,Helvetica;font-size:10px;line-height:12px;font-weight:normal;color:#000;}\n"
		.".menu_top {font-family:Verdana,Arial,Helvetica;font-size:11px;line-height:13px;font-weight:normal;}\n"
		.".menu_side {font-family:Verdana,Arial,Helvetica;font-size:11px;line-height:13px;font-weight:normal;}\n"
		.".menu_user {font-family:Verdana,Arial,Helvetica;font-size:16px;line-height:16px;}\n"
		.".title {font-family:\"Trebuchet MS\",Tahoma,Verdana,Arial,Helvetica;font-size:28px;line-height:30px;font-weight:bold;}\n"
		.".large {font-family:Verdana,Arial,Helvetica;font-size:13px;line-height:15px;}\n"
		.".normal {font-family:Verdana,Arial,Helvetica;font-size:11px;line-height:13px;}\n"
		.".small {font-family:Verdana,Arial,Helvetica;font-size:10px;line-height:12px;}\n"
		.".footer {font-family:Verdana,Arial,Helvetica;font-size:10px;line-height:10px;color:#aaa;}\n"
		."</style>\n"
		."</head>\n"
		."<body style='margin:0px;border:0px;padding:10px;' bgcolor='#eeeeee' text='#000000'>\n"
		."<table border='0' cellspacing='1' cellpadding='0' width='770' align='center' bgcolor='#aaaaa'><tr><td bgcolor='#ffffff'>\n"
		
		."<table border='0' cellspacing='0' cellpadding='0' width='100%'>\n"
		."<tr><td colspan='2'><!--banner--></td></tr>\n"
		."<tr><td colspan='2' bgcolor='#cccccc'><img src='images/pix1.gif' width='1' height='1'></td></tr>\n"
		."<tr><td colspan='2' align='right' bgcolor='#cccccc' background='images/bg.gif'><div style='padding:1px;'><!--menu_top--></div></td></tr>\n"
		."<tr><td colspan='2' bgcolor='#cccccc'><img src='images/pix1.gif' width='1' height='1'></td></tr>\n"
		."<tr>\n"
		."<td valign='top' width='150' style='border-right:1px dashed #ccc'><!--menu_side--></td>\n"
		."<td valign='top'><div style='padding:5px;'><!--content--></div></td>\n"
		."</tr>\n"
		."</table>\n"
		
		."</td></tr></table>\n"
		."</body>\n"
		."</html>\n";
	return $html;
}


// Description : Provides the banner across the top of the admin interface
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_banner(){
	$html = "<table border='0' cellspacing='0' cellpadding='2' width='100%' bgcolor='#ffffff'>\n"
		."<tr>\n"
		."<td align='left' class='banner_title'>&nbsp;PluggedOut Blog Administration Interface</td>\n"
		."<td align='right' class='normal'>";
	
	if (isset($_SESSION["blog_userid"])){
		$html .= "<table border='0' cellspacing='0' cellpadding='0'><tr><td class='normal'><a href='exec.php?action=user_logout'><img src='images/icon_logout_small.png' width='16' height='16' border='0' title='Logout'></a></td><td class='normal'>&nbsp;<a href='exec.php?action=user_logout'>Logout</a>&nbsp;</td></tr></table>\n";
	} else {
		$html .= "&nbsp;\n";
	}
	
	$html .= "</td>\n"
		."</tr>\n"
		."</table>\n";
		
	return $html;
}


// Description : Provides the menu bar across the top of the admin interface
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_menu_top(){
	
	$html = "<table border='0' cellspacing='0' cellpadding='1'><tr><td class='banner_smallprint'>Version 1.9.2 &copy; <a href='http://www.pluggedout.com/index.php?pk=dev_blog' title='Visit the development homepage'>PluggedOut</a>, 2005&nbsp;</td></tr></table>\n";
	return $html;
}


// Description : Provides the menu down the left side of the admin interface
//               Some sections are filtered according to your user role
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_menu_side(){
	
	if (isset($_SESSION["blog_userid"])){
	
		$html = "<div style='padding:5px;' width='100%'>\n"
			."<table border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc' width='100%'>\n";
		
		$html .= "<tr><td bgcolor='#ffffff' class='menu_side'><table align='center' border='0' cellspacing='0' cellpadding='3'><tr><td class='small'>Logged in as<br>&nbsp;&nbsp;<span class='menu_user'><b>".$_SESSION["blog_username"]."</b></span></td></tr></table></td></tr>\n";
	
		$html .= "<tr><td bgcolor='#cccccc' background='images/bg.gif' class='menu_side'><b>Main Menu</b></td></tr>\n"
			."<tr><td bgcolor='#ffffff' class='menu_side'>"
			."  <table border='0' cellspacing='0' cellpadding='2'>\n";
	
		// construct the menu according to the user role setting
		// (admin, author or contributor)
		$role = get_user_role($_SESSION["blog_userid"]);
		
		$html .= "<tr><td colspan='4' class='small'>&nbsp;</td></tr>\n"
			."<tr><td colspan='4' class='normal'><b>General</b></td></tr>\n"
			."<tr><td class='normal'>&nbsp;</td><td><img src='images/icon_home_small.png' width='16' height='16' title='Home'></td><td class='normal'>&nbsp;</td><td class='normal'><a href='index.php'>Home</a></td></tr>\n"
			."<tr><td class='normal'>&nbsp;</td><td><img src='images/icon_view_small.png' width='16' height='16' title='View'></td><td class='normal'>&nbsp;</td><td class='normal'><a href='../index.php'>View Blog</a></td></tr>\n"
			
			."<tr><td colspan='4' class='small'>&nbsp;</td></tr>\n"
			."<tr><td colspan='4' class='normal'><b>Entries</b></td></tr>\n"
			."<tr><td class='normal'>&nbsp;</td><td><img src='images/icon_entry_small.png' width='16' height='16' title='Add Entry'></td><td class='normal'>&nbsp;</td><td class='normal'><a href='index.php?action=entry_add'>Add Entry</a></td></tr>\n"
			."<tr><td class='normal'>&nbsp;</td><td><img src='images/icon_entry_small.png' width='16' height='16' title='List Entries'></td><td class='normal'>&nbsp;</td><td class='normal'><a href='index.php?action=entry_list'>List Entries</a></td></tr>\n";

			
		// admin only sections
		if ($role=="admin"){
			
			$html .= "<tr><td colspan='4' class='small'>&nbsp;</td></tr>\n"
				."<tr><td colspan='4' class='normal'><b>Users</b></td></tr>\n"
				."<tr><td class='normal'>&nbsp;</td><td><img src='images/icon_user_small.png' width='16' height='16' title='Add User'></td><td class='normal'>&nbsp;</td><td class='normal'><a href='index.php?action=user_add'>Add User</a></td></tr>\n"
				."<tr><td class='normal'>&nbsp;</td><td><img src='images/icon_users_small.png' width='16' height='16' title='List Users'></td><td class='normal'>&nbsp;</td><td class='normal'><a href='index.php?action=user_list'>List Users</a></td></tr>\n"
			
				."<tr><td colspan='4' class='small'>&nbsp;</td></tr>\n"
				."<tr><td colspan='4' class='normal'><b>Categories</b></td></tr>\n"
				."<tr><td class='normal'>&nbsp;</td><td><img src='images/icon_categories_small.png' width='16' height='16' title='Add Category'></td><td class='normal'>&nbsp;</td><td class='normal'><a href='index.php?action=category_add'>Add Category</a></td></tr>\n"
				."<tr><td class='normal'>&nbsp;</td><td><img src='images/icon_categories_small.png' width='16' height='16' title='List Categories'></td><td class='normal'>&nbsp;</td><td class='normal'><a href='index.php?action=category_list'>List Categories</a></td></tr>\n"
				
				."<tr><td colspan='4' class='small'>&nbsp;</td></tr>\n"
				."<tr><td colspan='4' class='normal'><b>Themes</b></td></tr>\n"
				."<tr><td class='normal'>&nbsp;</td><td><img src='images/icon_themes_small.png' width='16' height='16' title='Themes'></td><td class='normal'>&nbsp;</td><td class='normal'><a href='index.php?action=theme_list'>Theme List</a></td></tr>\n"
				
				."<tr><td colspan='4' class='small'>&nbsp;</td></tr>\n"
				."<tr><td colspan='4' class='normal'><b>Settings</b></td></tr>\n"
				."<tr><td class='normal'>&nbsp;</td><td><img src='images/icon_settings_small.png' width='16' height='16' title='Settings'></td><td class='normal'>&nbsp;</td><td class='normal'><a href='index.php?action=settings_edit'>Edit Settings</a></td></tr>\n"
				
				."<tr><td colspan='4' class='small'>&nbsp;</td></tr>\n"
				."<tr><td colspan='4' class='normal'><b>Files</b></td></tr>\n"
				."<tr><td class='normal'>&nbsp;</td><td><img src='images/icon_files_small.png' width='16' height='16' title='Files'></td><td class='normal'>&nbsp;</td><td class='normal'><a href='index.php?action=file_browse'>Browse Files</a></td></tr>\n"
				
				."<tr><td colspan='4' class='small'>&nbsp;</td></tr>\n"
				."<tr><td colspan='4' class='normal'><b>&nbsp;</b></td></tr>\n"
				."<tr><td class='normal'>&nbsp;</td><td><img src='images/icon_logout_small.png' width='16' height='16' title='Themes'></td><td class='normal'>&nbsp;</td><td class='normal'><a href='exec.php?action=user_logout'>Logout</a></td></tr>\n";
				
		}
		$html .= "  </table>\n&nbsp;\n"
			."</td></tr></table>\n";
	
	} else {
	
		$html .= "&nbsp;\n";
	
	}
	
	// put the PluggedOut Logo in place
	$html .= "<br><br><div style='padding:5px;text-align:center;'><a href='http://www.pluggedout.com' title='Powered by PluggedOut'><img src='images/powered_by_pluggedout.gif' title='Powered by PluggedOut' border='0'></a><br><span class='footer'>&copy; J Beckett, 2005<br>All Rights Reserved.</span></div>\n";
		
	$html .= "</div>\n";
	
	return $html;
}


// Description : Provides the home page of the admin interface
//               Some areas are dependent on the user role
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_welcome(){
	
	$html = "<div class='title'>Main Menu</div>\n"
		."<div class='small'>&nbsp;</div>\n"
		."<div class='normal'>Welcome to the PluggedOut Blog Administration Interface. Click on the links below to access areas of the Blog. Remember that some sections may be unavailable to you (and therefore not shown) depending on your level of authorisation.</div>\n"
		."<div class='small'>&nbsp;</div>\n"
		."<table width='100%' border='0' cellspacing='1' cellpadding='2' bgcolor='#cccccc'>\n"
		."<tr>\n"
		."  <td class='normal' bgcolor='#cccccc' background='images/bg.gif' align='center' width='25%'><b>Entries</b></td>\n"
		."  <td class='normal' bgcolor='#cccccc' background='images/bg.gif' align='center' width='25%'><b>Users</b></td>\n"
		."  <td class='normal' bgcolor='#cccccc' background='images/bg.gif' align='center' width='25%'><b>Categories</b></td>\n"
		."  <td class='normal' bgcolor='#cccccc' background='images/bg.gif' align='center' width='25%'><b>Misc</b></td>\n"
		."</tr>\n"
		."<tr>\n"
		."  <td class='normal' bgcolor='#ffffff' align='center' width='25%' valign='top'>"
		."    <div class='normal'>&nbsp;</div>\n"
		."    <div class='normal'><a href='index.php?action=entry_add'><img src='images/icon_entry.png' width='48' height='52' border='0' title='Add Entry'><br>Add Entry</a></div>\n"
		."    <div class='normal'>&nbsp;</div>\n"
		."    <div class='normal'><a href='index.php?action=entry_list'><img src='images/icon_entry.png' width='48' height='52' border='0' title='List Entries'><br>List Entries</a></div>\n"
		."    <div class='normal'>&nbsp;</div>\n"
		."  </td>\n";
	
	if (get_user_role($_SESSION["blog_userid"])=="admin"){
		$html .= "  <td class='normal' bgcolor='#ffffff' align='center' width='25%' valign='top'>"
			."    <div class='normal'>&nbsp;</div>\n"
			."    <div class='normal'><a href='index.php?action=user_add'><img src='images/icon_user.png' width='48' height='48' border='0' title='Add User'><br>Add User</a></div>\n"
			."    <div class='normal'>&nbsp;</div>\n"
			."    <div class='normal'><a href='index.php?action=user_list'><img src='images/icon_users.png' width='47' height='48' border='0' title='List Users'><br>List Users</a></div>\n"
			."    <div class='normal'>&nbsp;</div>\n"
			."  </td>\n"
			."  <td class='normal' bgcolor='#ffffff' align='center' width='25%' valign='top'>"
			."    <div class='normal'>&nbsp;</div>\n"
			."    <div class='normal'><a href='index.php?action=category_add'><img src='images/icon_categories.png' width='48' height='48' border='0' title='Add Category'><br>Add Category</a></div>\n"
			."    <div class='normal'>&nbsp;</div>\n"
			."    <div class='normal'><a href='index.php?action=category_list'><img src='images/icon_categories.png' width='48' height='48' border='0' title='List Categories'><br>List Categories</a></div>\n"
			."    <div class='normal'>&nbsp;</div>\n"
			."  </td>\n"
			."  <td class='normal' bgcolor='#ffffff' align='center' width='25%' valign='top'>"
			."    <div class='normal'>&nbsp;</div>\n"
			."    <div class='normal'><a href='index.php?action=theme_list'><img src='images/icon_themes.png' width='48' height='52' border='0' title='Themes'><br>Themes</a></div>\n"
			."    <div class='normal'>&nbsp;</div>\n"
			."    <div class='normal'><a href='index.php?action=settings_edit'><img src='images/icon_search.png' width='48' height='47' border='0' title='Settings'><br>Settings</a></div>\n"
			."    <div class='normal'>&nbsp;</div>\n"
			."    <div class='normal'><a href='index.php?action=file_browse'><img src='images/icon_files.png' width='48' height='46' border='0' title='Files'><br>Files</a></div>\n"
			."    <div class='normal'>&nbsp;</div>\n"
			."  </td>\n"
			."</tr>\n"
			."</table>\n";
	} else {
		$html .= "  <td class='normal' bgcolor='#ffffff' align='center' width='25%' valign='top'>"
			."    <div class='normal'>&nbsp;</div>\n"
			."  </td>\n"
			."  <td class='normal' bgcolor='#ffffff' align='center' width='25%' valign='top'>"
			."    <div class='normal'>&nbsp;</div>\n"
			."  </td>\n"
			."  <td class='normal' bgcolor='#ffffff' align='center' width='25%' valign='top'>"
			."    <div class='normal'>&nbsp;</div>\n"
			."  </td>\n"
			."</tr>\n"
			."</table>\n";
	}	
	return $html;
}


// Description : Displays the blog entry list for the administration interface
//               - allows searching, and category filtering
// Arguments   : None (is uses _REQUEST parameters)
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_entry_list(){
	
	$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
		."<tr>"
		."  <td rowspan='2'><img src='images/icon_entry.png' width='48' height='52' title='Entry List'></td>"
		."  <td class='title'>Entry List</div>\n"
		."</tr><tr>"
		."  <td class='normal'>This section shows the entries within the blog, with the option to edit or remove each entry.</td>\n"
		."</tr>\n"
		."</table>\n"
		."<br>\n";
		
	global $db_prefix;
	
	$con = db_connect();
	
	if (isset($_REQUEST["list_from"])){
		$list_from = $_REQUEST["list_from"];
	} else {
		$list_from = 0;
	}
	
	// Prepare Status Select
	// (P = Published, U = Unpublished/Unapproved)
	$html_status_select = "<select name='status' class='normal'><option value=''></option>\n";
	if (isset($_REQUEST["status"])){
		switch ($_REQUEST["status"]){
			case "U":
				$status = "U";
				$html_status_select .= "<option value='P'>Published</option><option value='U' selected>Un-Published</option>\n";
				break;
			default:
				$status = "P";
				$html_status_select .= "<option value='P' selected>Published</option><option value='U'>Un-Published</option>\n";
		}
	} else {
		$status = "P";
		$html_status_select .= "<option value='P' selected>Published</option><option value='U'>Un-Published</option>\n";
	}
	$html_status_select .= "</select>\n";
	
	// prepare category select
	$html_category_select = "<select name='categoryid' class='normal'><option value=''></option>\n";
	$sql = "SELECT * FROM ".$db_prefix."categories ORDER BY cCategoryName";
	$result = mysql_query($sql,$con);
	if ($result!=false){
		if (mysql_num_rows($result)>0){
			while ($row=@mysql_fetch_array($result)){
				if (isset($_REQUEST["categoryid"])){
					if ($_REQUEST["categoryid"]==$row["nCategoryId"]){
						$selected = "selected";
					} else {
						$selected = "";
					}
				}
				$html_category_select .= "<option value='".$row["nCategoryId"]."' ".$selected.">".stripslashes($row["cCategoryName"])."</option>\n";
			}
		} else {
			$html_category_select .= "<option value=''>None Found</option>\n";
		}
	} else {
		$html_category_select .= "<option value=''>None Found</option>\n";
	}
	$html_category_select .= "</select>\n";
	
	// work out how we should filter the list
	if (isset($_REQUEST["list_from"])){
		$list_from=$_REQUEST["list_from"];
	} else {
		$list_from = 0;
	}
	
	$results_per_page = get_setting("results_per_page");
	
	// construct SQL where clause
	
	// handle search keywords
	if (isset($_REQUEST["keywords"])){
		$keywords=$_REQUEST["keywords"];
		if ($keywords!=""){
			$a_keywords = explode(" ",$keywords);
			foreach ($a_keywords as $keyword){
				$sql_keywords[] = "(ent.cBody LIKE '%".$keyword."%')";
			}
			$a_sql_where[] = "(".implode(" AND ",$sql_keywords).")";
		}
	}
	
	// handle status
	if (isset($_REQUEST["status"])){
		$status = $_REQUEST["status"];
		if ($status!=""){
			$a_sql_where[] = "(ent.cStatus='".$status."')";
		}
	}
	
	// handle category
	if (isset($_REQUEST["categoryid"])){
		$categoryid=$_REQUEST["categoryid"];
		if ($categoryid!=""){
			$a_sql_where[] = "(entcat.nCategoryId=".$categoryid.")";
		}
	}
	
	// handle month and year
	if (isset($_REQUEST["month"]) && isset($_REQUEST["year"])){
		$month = $_REQUEST["month"];
		$year = $_REQUEST["year"];
		if ($month!="" && $year!=""){
			$a_sql_where[] = "(ent.dAdded>'2001-01-01')";
		}
	}

	// work out user role
	$role = get_user_role($_SESSION["blog_userid"]);
	
	// handle users that are not admins
	if ($role!="admin"){
		$a_sql_where[] = "(ent.nUserAdded=".$_SESSION["blog_userid"].")";
	}

	// construct the SQL
	if (is_array($a_sql_where)){
		$sql_where_clauses = implode(" AND ",$a_sql_where);
	}
	if ($sql_where_clauses!=""){
		$sql_where = " WHERE ".$sql_where_clauses."\n";
	}
	
	
	$con = db_connect();

	// start control output
	$html .= "<form method='POST' action='index.php?action=entry_list'>\n"
		."<input type='hidden' name='list_from' value='".$list_from."'>\n"
		."<table border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
		."<tr><td colspan='2' class='normal' bgcolor='#cccccc' background='images/bg.gif'><b>List Controls</b></td></tr>\n"
		."<tr><td class='normal' bgcolor='#ffffff'>Search</td><td bgcolor='#ffffff'><input type='text' name='keywords' class='text' size='20' value='".$_REQUEST["keywords"]."'></td></tr>\n"
		."<tr><td class='normal' bgcolor='#ffffff'>Category</td><td bgcolor='#ffffff'>".$html_category_select."</td></tr>\n"
		."<tr><td class='normal' bgcolor='#ffffff'>Status</td><td bgcolor='#ffffff'>".$html_status_select."</td></tr>\n"
		."<tr><td colspan='2' bgcolor='#ffffff' align='right'><input type='submit' value='Go'></td></tr>\n"
		."</table>\n"
		."</form>\n";

	// form actual SQL
	$sql_count = "SELECT DISTINCT ent.nEntryId,ent.nUserAdded,ent.cTitle,ent.dAdded,usr.cUsername,ent.cStatus,ent.nComments"
		." FROM ".$db_prefix."entries ent"
		." INNER JOIN ".$db_prefix."users usr ON ent.nUserAdded=usr.nUserId"
		." LEFT OUTER JOIN ".$db_prefix."entry_categories entcat ON ent.nEntryId=entcat.nEntryId"
		.$sql_where;
		
	$sql = "SELECT DISTINCT ent.nEntryId,ent.nUserAdded,ent.cTitle,ent.dAdded,usr.cUsername,ent.cStatus,ent.nComments"
		." FROM ".$db_prefix."entries ent"
		." INNER JOIN ".$db_prefix."users usr ON ent.nUserAdded=usr.nUserId"
		." LEFT OUTER JOIN ".$db_prefix."entry_categories entcat ON ent.nEntryId=entcat.nEntryId"
		.$sql_where
		." ORDER BY ent.dAdded DESC"
		." LIMIT ".$list_from.",".$results_per_page;
	
	$result_count = mysql_query($sql_count,$con);
	$result = mysql_query($sql,$con);
	
	if ($result!=false){

		$count = mysql_num_rows($result_count);
		$html_pagelinks = "List Results (".$count." records in total) : ";

		if ($count<$list_from){
				$list_from = 0;
		}

		for($i=0;$i<$count;$i+=$results_per_page){
			$start = $i;
			if ($i>=($count-$results_per_page)){
				$start = $i;
				$end = $count-1;
			} else {
				$start = $i;
				$end = $i+$results_per_page-1;
			}
			$html_link = "<a href='index.php?action=entry_list&list_from=".$start."'>".($start+1)." to ".($end+1)."</a>";
			if ($i==$list_from){
				$html_pagelinks .= "<b>".$html_link."</b>&nbsp;";
			} else {
				$html_pagelinks .= $html_link."&nbsp;";
			}
		}

		$html .= "<table align='left' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
			."<tr><td colspan='6' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>Entries</b></td></tr>\n"
			."<tr><td colspan='6' bgcolor='#ffffff' class='small'>".$html_pagelinks."</td></tr>\n"
			."<tr>"
			."<td bgcolor='#dddddd' class='normal' background='images/bg.gif'><b>Date Added</b></td>"
			."<td bgcolor='#dddddd' class='normal' background='images/bg.gif'><b>Title</b></td>"
			."<td bgcolor='#dddddd' class='normal' background='images/bg.gif'><b>Comments</b></td>"
			."<td bgcolor='#dddddd' class='normal' background='images/bg.gif'><b>Author</b></td>"
			."<td bgcolor='#dddddd' class='normal' background='images/bg.gif'><b>Status</b></td>"
			."<td bgcolor='#dddddd' class='normal' background='images/bg.gif'><b>Controls</b></td>"
			."</tr>\n";
			
		if (mysql_num_rows($result)>0){
		
			while ($row=@mysql_fetch_array($result)){
			
				$html .= "<tr>"
					."<td bgcolor='#ffffff' class='normal'>".$row["dAdded"]."</td>"
					."<td bgcolor='#ffffff' class='normal'><a href='index.php?action=entry_edit&entryid=".$row["nEntryId"]."' title='Edit Entry'>".stripslashes($row["cTitle"])."</a></td>"
					."<td bgcolor='#ffffff' class='normal'><a href='index.php?action=entry_view&entryid=".$row["nEntryId"]."' title='View Comments'>".$row["nComments"]."</a> (<a href='index.php?action=entry_view&entryid=".$row["nEntryId"]."' title='View Comments'>view</a>)</td>"
					."<td bgcolor='#ffffff' class='normal'>".stripslashes($row["cUsername"])."</td>"
					."<td bgcolor='#ffffff' class='normal'>".stripslashes($row["cStatus"])."</td>"
					."<td bgcolor='#ffffff' class='normal'>";
				
				$html_edit = "&nbsp;<a href='index.php?action=entry_edit&entryid=".$row["nEntryId"]."' title='Edit Entry'>Edit</a>";
				$html_remove = "&nbsp;<a href='index.php?action=entry_remove&entryid=".$row["nEntryId"]."' title='Remove Entry'>Remove</a>";
				$html_publish = "&nbsp;<a href='exec.php?action=entry_publish&entryid=".$row["nEntryId"]."' title='Publish Entry'>Publish</a>";
				$html_unpublish = "&nbsp;<a href='exec.php?action=entry_unpublish&entryid=".$row["nEntryId"]."' title='Unpublish Entry'>Un-Publish</a>";
				
				switch ($role){
				
					case "admin":
					
						// we are admin - we can do anything - including publish/unpublish
						if ($row["cStatus"]=="P"){
							// show unpublish button
							$html .= $html_unpublish;
						} else {
							// show publish button
							$html .= $html_publish;
						}
						$html .= $html_edit;
						$html .= $html_remove;
						break;
						
					case "author":
					
						// we are an author - we can publish our own work
						//                  - we can edit our own work
						//                  - we can remove our own work
						if ($row["nUserAdded"]==$_SESSION["blog_userid"]){
													
							if ($row["cStatus"]=="P"){
								// show unpublish button
								$html .= $html_unpublish;
							} else {
								// show publish button
								$html .= $html_publish;
							}
							// show the edit and remove buttons
							$html .= $html_edit;
							$html .= $html_remove;
							
						}
						break;
						
					case "contributor":
					
						// we are a contributor - we can add entries as unpublished
						//                      - we can edit unpublished work we wrote
						//                      - we can remove unpublished work we wrote
						if ($row["nUserAdded"]==$_SESSION["blog_userid"]){
						
							if ($row["cStatus"]=="U"){
								// show edit and remove buttons
								$html .= $html_edit;
								$html .= $html_remove;
							}
							
						}
						break;
						
					
				}
					
				$html .= "</td>"
					."</tr>\n";
			}
		} else {
			$html .= "<tr><td colspan='6' bgcolor='#ffffff' class='normal' align='center'>No Entries Returned</td></tr>\n";
		}
		
		$html .= "</table>\n";
		
	} else {
		//report_problem(1,"html_entry_list ".$sql);
		print $sql;
	}
	
	db_disconnect($con);
	
	return $html;
}


// Description : Shows the form to add a blog entry
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-07-13
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_entry_add(){

	$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
		."<tr>"
		."  <td rowspan='2'><img src='images/icon_entry.png' width='48' height='52' title='Add Entry'></td>"
		."  <td class='title'>Add Entry</div>\n"
		."</tr><tr>"
		."  <td class='normal'>Fill in the form below to add an entry to the blog - and don't forget to set some categories to file your entry against. Remember that if you are only a 'contributor' user, your entry will not automatically be set to 'Publish'.</td>\n"
		."</tr>\n"
		."</table>\n"
		."<br>\n";
		
	global $db_prefix;
	

	$con = db_connect();

	// build categorylist checkboxes	
	$sql = "SELECT * FROM ".$db_prefix."categories ORDER BY cCategoryName";
	$result = mysql_query($sql,$con);
	if ($result!=false){
		$cat_count = mysql_num_rows($result);
		if ($cat_count>0){
			$html_categories = "<table border='0' cellspacing='0' cellpadding='1'>\n";
			while ($row =@ mysql_fetch_array($result)){
				$html_categories .= "<tr><td class='normal'><input type='checkbox' name='cat".$row["nCategoryId"]."' value='x'></td><td class='normal'>".stripslashes($row["cCategoryName"])."</td></tr>\n";
			}
			$html_categories .= "</table>\n";
		} else {
			$html_categories = "There are no categories defined.";
		}
	} else {
		report_problem(1,"html_entry_add ".$sql);
	}
	
	db_disconnect($con);

	// use our role to determine the published status
	$role = get_user_role($_SESSION["blog_userid"]);
	if ($role!="contributor"){
		$html_publish = "<select name='status' class='text'><option value='P'>Published</option><option value='U'>Un-Published</option></select>\n";
	} else {
		$html_publish = "<span class='normal'>Unpublished (Contributor)</span>";
	}

	$html .= "<form method='POST' action='exec.php?action=entry_add'>\n"
		."<table align='left' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
		."<tr><td colspan='3' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>Entry Add Form</b></td></tr>\n"
		."<tr>"
		."<td bgcolor='#ffffff' class='normal'>Title</td><td bgcolor='#ffffff'><input type='text' name='title' size='60' class='text'></td>"
		."<td width='150' rowspan='4' bgcolor='#ffffff' class='normal' valign='top'>Categories...<br><input type='hidden' name='catcount' value='".$cat_count."'>".$html_categories."</td>"
		."</tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Date</td><td bgcolor='#ffffff'><input type='text' name='dateadded' size='30' class='text' value='".date("Y-m-d H:i:s")."'></td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Status</td><td bgcolor='#ffffff'>".$html_publish."</td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Body</td><td bgcolor='#ffffff'><textarea name='body' cols='50' rows='15' class='text'></textarea></td></tr>\n"
		."<tr><td colspan='3' bgcolor='#ffffff' class='normal' align='right'><input type='submit' value='Add Entry'></td></tr>\n"
		."</form>\n";
		
	return $html;
}


// Description : Provides the entry editing form
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_entry_edit($entryid){
		
	global $db_prefix;
	
	$con = db_connect();
	
	// get the existing entry
	$sql = "SELECT * FROM ".$db_prefix."entries WHERE nEntryId=".$entryid;
	$entry_result = mysql_query($sql,$con);
	if ($entry_result!=false){
		if (mysql_num_rows($entry_result)>0){
			$entry_row = mysql_fetch_array($entry_result);
		} else {
			// could not find entry
		}
	} else {
		// problem with sql
	}
	
	// get the existing categories the entry is filed against
	$sql = "SELECT * FROM ".$db_prefix."entry_categories WHERE nEntryId=".$entryid;
	$entcat_result = mysql_query($sql,$con);
	if ($entcat_result!=false){
		if (mysql_num_rows($entcat_result)>0){
			while ($entcat_row=@mysql_fetch_array($entcat_result)){
				$a_entry_categories[$entcat_row["nCategoryId"]]="x";
			}
		}
	} else {
		// problem with sql
	}
	
	// build categorylist checkboxes for the editing form
	$sql = "SELECT * FROM ".$db_prefix."categories ORDER BY cCategoryName";
	$cat_result = mysql_query($sql,$con);
	if ($cat_result!=false){
		$cat_count = mysql_num_rows($cat_result);
		if ($cat_count>0){
			$html_categories = "<table border='0' cellspacing='0' cellpadding='1'>\n";
			while ($cat_row =@ mysql_fetch_array($cat_result)){
				// hilight the category if it is chosen in the entry_categories array we have already built
				if ($a_entry_categories[$cat_row["nCategoryId"]]!=""){
					$checked = "checked";
				} else {
					$checked = "";
				}
				$html_categories .= "<tr><td class='normal'><input type='checkbox' name='cat".$cat_row["nCategoryId"]."' value='x' ".$checked."></td><td class='normal'>".stripslashes($cat_row["cCategoryName"])."</td></tr>\n";
			}
			$html_categories .= "</table>\n";
		} else {
			$html_categories = "There are no categories defined.";
		}
	} else {
		report_problem(1,"html_entry_edit ".$sql);
	}

	db_disconnect($con);

	// work out what role we are to set the publish field, and use the entry_row to default it
	// (apart from contributor status, where changes cause unpublishing)
	$role = get_user_role($_SESSION["blog_userid"]);
	if ($entry_row["cStatus"]=="P"){
		$select_published = "selected";
		$select_unpublished = "";
	} else {
		$select_published = "";
		$select_unpublished = "selected";
	}
	if ($role!="contributor"){
		$html_publish = "<select name='status' class='text'><option value='P' ".$select_published.">Published</option><option value='U' ".$select_unpublished.">Un-Published</option></select>\n";
	} else {
		$html_publish = "<span class='normal'>Unpublished (Contributor)</span>";
	}
	
	// build the html entry editing form
	$role = get_user_role($_SESSION["blog_userid"]);
	if ($_SESSION["blog_userid"]==$entry_row["nUserAdded"] || $role == "admin"){

		$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
			."<tr>"
			."  <td rowspan='2'><img src='images/icon_entry.png' width='48' height='52' title='Edit Entry'></td>"
			."  <td class='title'>Edit Entry</div>\n"
			."</tr><tr>"
			."  <td class='normal'>Use the form below to make changes to a blog entry. Remember to click the 'Make Changes' button when you have finished.</td>\n"
			."</tr>\n"
			."</table>\n"
			."<br>\n";

		$html .= "<form method='POST' action='exec.php?action=entry_edit'>\n"
			."<input type='hidden' name='entryid' value='".$entry_row["nEntryId"]."'>\n"
			."<table align='left' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
			."<tr><td colspan='3' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>Entry Edit Form</b></td></tr>\n"
			."<tr>"
			."<td bgcolor='#ffffff' class='normal'>Title</td><td bgcolor='#ffffff'><input type='text' name='title' size='60' class='text' value='".htmlspecialchars(stripslashes($entry_row["cTitle"]))."'></td>"
			."<td width='150' rowspan='4' bgcolor='#ffffff' class='normal' valign='top'>Categories...<br><input type='hidden' name='catcount' value='".$cat_count."'>".$html_categories."</td>"
			."</tr>\n"
			."<tr><td bgcolor='#ffffff' class='normal'>Date</td><td bgcolor='#ffffff'><input type='text' name='dateadded' size='30' class='text' value='".stripslashes($entry_row["dAdded"])."'></td></tr>\n"
			."<tr><td bgcolor='#ffffff' class='normal'>Status</td><td bgcolor='#ffffff'>".$html_publish."</td></tr>\n"
			."<tr><td bgcolor='#ffffff' class='normal'>Body</td><td bgcolor='#ffffff'><textarea name='body' cols='50' rows='15' class='text'>".htmlspecialchars(stripslashes($entry_row["cBody"]))."</textarea></td></tr>\n"
			."<tr><td colspan='3' bgcolor='#ffffff' class='normal' align='right'><input type='submit' value='Make Changes'></td></tr>\n"
			."</form>\n";
		
	} else {
	
		$html .= html_forbidden();
		
	}
	
	return $html;
}


// Description : Provides the entry removal form
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_entry_remove($entryid){
		
	global $db_prefix;
	
	$con = db_connect();
	
	// get the existing entry
	$sql = "SELECT * FROM ".$db_prefix."entries WHERE nEntryId=".$entryid;
	$entry_result = mysql_query($sql,$con);
	if ($entry_result!=false){
		if (mysql_num_rows($entry_result)>0){
			$entry_row = mysql_fetch_array($entry_result);
		} else {
			// could not find entry
		}
	} else {
		// problem with sql
	}
	
	// get the existing categories the entry is filed against
	$sql = "SELECT entcat.nCategoryId,cat.cCategoryName FROM ".$db_prefix."entry_categories entcat"
		." INNER JOIN ".$db_prefix."categories cat ON entcat.nCategoryId=cat.nCategoryId"
		." WHERE entcat.nEntryId=".$entryid;
		
	$entcat_result = mysql_query($sql,$con);
	if ($entcat_result!=false){
		if (mysql_num_rows($entcat_result)>0){
			while ($entcat_row=@mysql_fetch_array($entcat_result)){
				$html_catlist .= stripslashes($entcat_row["cCategoryName"])."&nbsp;";
			}
		} else {
			$html_catlist = "Not filed against any categories";
		}
	} else {
		// problem with sql
		report_problem(1,"html_entry_remove ".$sql);
	}
	
	db_disconnect($con);

	// build the html entry editing form

	$role = get_user_role($_SESSION["blog_userid"]);
	
	if (($_SESSION["blog_userid"]==$entry_row["nUserAdded"] && $role!="contributor") || $role=="admin"){
	
		$html = "<div class='title'>Entry Remove Form</div>\n"
			."<div class='small'>You have chosen to remove this entry. Please check that the entry displayed below is correct before clicking on 'Remove Entry'. Be careful - you cannot undo this operation.</div>\n"
			."<br>\n";
			
		$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
			."<tr>"
			."  <td rowspan='2'><img src='images/icon_entry.png' width='48' height='52' title='Remove Entry'></td>"
			."  <td class='title'>Remove Entry</div>\n"
			."</tr><tr>"
			."  <td class='normal'>Use the form below to make changes to a blog entry. Remember to click the 'Make Changes' button when you have finished.</td>\n"
			."</tr>\n"
			."</table>\n"
			."<br>\n";


		$html .= "<form method='POST' action='exec.php?action=entry_remove'>\n"
			."<input type='hidden' name='entryid' value='".$entry_row["nEntryId"]."'>\n"
			."<table align='left' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
			."<tr><td colspan='3' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>Remove Entry</b></td></tr>\n"
			."<tr><td bgcolor='#ffffff' class='normal'>Title</td><td bgcolor='#ffffff' class='normal'>".stripslashes($entry_row["cTitle"])."</td></tr>\n"
			."<tr><td bgcolor='#ffffff' class='normal'>Date</td><td bgcolor='#ffffff' class='normal'>".stripslashes($entry_row["dAdded"])."</td></tr>\n"
			."<tr><td bgcolor='#ffffff' class='normal'>Categories</td><td bgcolor='#ffffff' class='normal'>".$html_catlist."</td></tr>\n"
			."<tr><td bgcolor='#ffffff' class='normal'>Body</td><td bgcolor='#ffffff' class='normal'>".nl2br(htmlspecialchars(stripslashes($entry_row["cBody"])))."</td></tr>\n"
			."<tr><td colspan='3' bgcolor='#ffffff' class='normal' align='right'><input type='submit' value='Remove Entry'></td></tr>\n"
			."</form>\n";

	} else {
	
		$html .= html_forbidden();
	
	}
	return $html;
}


// Description : Provides the entry view form
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_entry_view($entryid){

	$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
		."<tr>"
		."  <td rowspan='2'><img src='images/icon_entry.png' width='48' height='52' title='View Entry'></td>"
		."  <td class='title'>View Entry</div>\n"
		."</tr><tr>"
		."  <td class='normal'>The view entry form shows you the entry, and any comments it may have. You can use this form to edit and remove comments.</td>\n"
		."</tr>\n"
		."</table>\n"
		."<br>\n";
			
	global $db_prefix;
	
	$con = db_connect();
	
	// get the existing entry
	$sql = "SELECT * FROM ".$db_prefix."entries WHERE nEntryId=".$entryid;
	$entry_result = mysql_query($sql,$con);
	if ($entry_result!=false){
		if (mysql_num_rows($entry_result)>0){
			$entry_row = mysql_fetch_array($entry_result);
		} else {
			// could not find entry
		}
	} else {
		// problem with sql
	}
	
	// get the existing categories the entry is filed against
	$sql = "SELECT entcat.nCategoryId,cat.cCategoryName FROM ".$db_prefix."entry_categories entcat"
		." INNER JOIN ".$db_prefix."categories cat ON entcat.nCategoryId=cat.nCategoryId"
		." WHERE entcat.nEntryId=".$entryid;
		
	$entcat_result = mysql_query($sql,$con);
	if ($entcat_result!=false){
		if (mysql_num_rows($entcat_result)>0){
			while ($entcat_row=@mysql_fetch_array($entcat_result)){
				$html_catlist .= stripslashes($entcat_row["cCategoryName"])."&nbsp;";
			}
		} else {
			$html_catlist = "Not filed against any categories";
		}
	} else {
		// problem with sql
		report_problem(1,"html_entry_remove ".$sql);
	}
	
	// show the entry
	$html .= "<table align='left' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
		."<tr><td colspan='4' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>View Entry</b></td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Title</td><td bgcolor='#ffffff' class='normal'>".stripslashes($entry_row["cTitle"])."</td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Date</td><td bgcolor='#ffffff' class='normal'>".stripslashes($entry_row["dAdded"])."</td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Categories</td><td bgcolor='#ffffff' class='normal'>".$html_catlist."</td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Body</td><td bgcolor='#ffffff' class='normal'>".nl2br(htmlspecialchars(stripslashes($entry_row["cBody"])))."</td></tr>\n"
		."<tr><td colspan='4' bgcolor='#cccccc' class='normal'><b>Comments</b></td></tr>\n";
	
	$sql = "SELECT * FROM ".$db_prefix."comments WHERE nEntryId=".$entryid." ORDER BY dAdded";
	$comment_result = mysql_query($sql,$con);
	if ($comment_result!=false){
		if (mysql_num_rows($comment_result)>0){
			$html .= "<tr><td colspan='4' bgcolor='#ffffff' class='normal'>\n"
				."<table border='0' cellspacing='1' cellpadding='3' width='100%' bgcolor='#cccccc'>\n";
			while ($comment_row =@ mysql_fetch_array($comment_result)){
				$comment = htmlspecialchars(stripslashes($comment_row["cComment"]));
				$name = htmlspecialchars(stripslashes($comment_row["cName"]));
				if ($comment_row["cEMail"]!=""){
					$email = "(<a href='mailto:".htmlspecialchars(stripslashes($comment_row["cEMail"]))."'>E-Mail</a>)&nbsp;";
				} else {
					$email = "&nbsp;";
				}
				if ($comment_row["cURL"]!=""){
					$url = "(<a href='".htmlspecialchars(stripslashes($comment_row["cURL"]))."'>URL</a>)&nbsp;";
				} else {
					$url = "&nbsp;";
				}
				$date_added = htmlspecialchars(stripslashes($comment_row["dAdded"]));
				$html .= "<tr><td bgcolor='#ffffff' class='small'>"
					."<span class='normal'>".$comment."</span>"
					."<br>by ".$name." on ".$date_added." ".$email." ".$url
					."</td><td bgcolor='#ffffff' class='small' align='center' width='75'>"
					."<a href='index.php?comment_edit&commentid=".$comment_row["nCommentId"]."'>Edit</a>"
					."<br><a href='index.php?comment_remove&commentid=".$comment_row["nCommentId"]."'>Remove</a>"
					."</td></tr>\n";
			}
			$html .= "</table>\n"
				."</td></tr>\n";
		} else {
			$html .= "<tr><td colspan='4' bgcolor='#ffffff' class='normal' align='center'>This entry has no comments yet.</td></tr>\n";
		}
	} else {
		report_problem(1,"html_view_entry ".$sql);
	}
		
	$html .= "</table>\n";
	
	
	db_disconnect($con);
	
	return $html;
}


// Description : Provides the Login form
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_login(){
	$html = "<br>\n"
		."<form method='POST' action='exec.php?action=user_login'>\n"
		."<table align='center' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
		."<tr><td colspan='2' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>Login Form</b></td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Username</td><td bgcolor='#ffffff'><input type='text' name='username' class='text'></td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Password</td><td bgcolor='#ffffff'><input type='password' name='password' class='text'></td></tr>\n"
		."<tr><td colspan='2' bgcolor='#ffffff' align='right'><input type='submit' value='Login' class='button'></td></tr>\n"
		."</table>\n"
		."</form>\n";
	return $html;
}


// Description : Provides the theme list form, from which the
//               admin user can choose the default theme
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_themes_list(){

	$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
		."<tr>"
		."  <td rowspan='2'><img src='images/icon_themes.png' width='48' height='52' title='Themes'></td>"
		."  <td class='title'>Themes</div>\n"
		."</tr><tr>"
		."  <td class='normal'>The list below shows the themes that exist within the 'themes' directory on your webserver. To use a particular theme, click the 'Select' link next to it.</td>\n"
		."</tr>\n"
		."</table>\n"
		."<br>\n";
		
	$html .= "<table align='left' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
		."<tr><td colspan='3' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>Themes</b></td></tr>\n"
		."<tr>"
		."<td bgcolor='#dddddd' class='normal'>Theme Name</td>"
		."<td bgcolor='#dddddd' class='normal'>Selected</td>"
		."<td bgcolor='#dddddd' class='normal'>Controls</td>"
		."</tr>\n";
	
	$current_theme = get_setting("theme");
	
	// look through the themes directory
	$themes_dir = realpath("../themes");
	if (is_dir($themes_dir)) {
		if ($dh = opendir($themes_dir)) {
			while (($file = readdir($dh)) !== false) {
				if ($file!="." && $file!=".." && is_dir($themes_dir."/".$file)){
					if ($current_theme == $file){
						$selected = "Selected";
					} else {
						$selected = "&nbsp;";
					}
					$html .= "<tr>"
						."<td bgcolor='#ffffff' class='normal'>".$file."</td>"
						."<td bgcolor='#ffffff' class='normal'>".$selected."</td>"
						."<td bgcolor='#ffffff' class='normal'><a href='exec.php?action=theme_set&theme=".$file."'>Select</a></td>"
						."</tr>\n";
				}
			}
			closedir($dh);
		} else {
			$html .= "<tr><td colspan='3' bgcolor='#ffffff' class='normal' align='center'>Cannot open themes directory</td></tr>\n";
		}
	} else {
		$html .= "<tr><td colspan='3' bgcolor='#ffffff' class='normal' align='center'>Cannot find themes directory</td></tr>\n";
	}
	$html .= "</table>\n";
	
	return $html;
}


// Description : Provides the category list form
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_category_list(){

	$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
		."<tr>"
		."  <td rowspan='2'><img src='images/icon_categories.png' width='48' height='52' title='Category List'></td>"
		."  <td class='title'>Category List</div>\n"
		."</tr><tr>"
		."  <td class='normal'>The list below shows the categories you can file entries against. You can edit and remove categories from here.</td>\n"
		."</tr>\n"
		."</table>\n"
		."<br>\n";
		
	global $db_prefix;
	
	$html .= "<table align='left' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
		."<tr><td colspan='2' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>Category List</b></td></tr>\n"
		."<tr>"
		."<td bgcolor='#dddddd' class='normal'>Category Name</td>"
		."<td bgcolor='#dddddd' class='normal'>Control</td>"
		."</tr>\n";

	$con = db_connect();
	
	$sql = "SELECT * FROM ".$db_prefix."categories ORDER BY cCategoryName";
	$result = mysql_query($sql,$con);
	if ($result!=false){
		if (mysql_num_rows($result)>0){
			while ($row=@mysql_fetch_array($result)){
				$html .= "<tr>"
					."<td bgcolor='#ffffff' class='normal'>".stripslashes($row["cCategoryName"])."</td>"
					."<td bgcolor='#ffffff' class='normal'>"
					."<a href='index.php?action=category_edit&categoryid=".$row["nCategoryId"]."'>Edit</a>"
					."&nbsp;<a href='index.php?action=category_remove&categoryid=".$row["nCategoryId"]."'>Remove</a>"
					."</td>"
					."</tr>\n";
			}
		} else {
			$html .= "<tr><td colspan='2' bgcolor='#ffffff' class='normal' align='center'>There are no categories</td></tr>\n";
		}
	} else {
		report_problem(1,"html_category_list ".$sql);
	}
	
	db_disconnect($con);
	
	$html .= "</table>\n";
	
	return $html;
}


// Description : Provides the user list form
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_user_list(){

	$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
		."<tr>"
		."  <td rowspan='2'><img src='images/icon_users.png' width='48' height='52' title='User List'></td>"
		."  <td class='title'>User List</div>\n"
		."</tr><tr>"
		."  <td class='normal'>The table below shows the users of the system. You can edit and remove users from here if you are an 'Administrator'.</td>\n"
		."</tr>\n"
		."</table>\n"
		."<br>\n";
		
	global $db_prefix;
	
	$html .= "<table align='left' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
		."<tr><td colspan='4' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>User List</b></td></tr>\n"
		."<tr>"
		."<td bgcolor='#dddddd' class='normal'>Username</td>"
		."<td bgcolor='#dddddd' class='normal'>Role</td>"
		."<td bgcolor='#dddddd' class='normal'>EMail</td>"
		."<td bgcolor='#dddddd' class='normal'>Control</td>"
		."</tr>\n";
		
	$con = db_connect();
	
	$sql = "SELECT * FROM ".$db_prefix."users ORDER BY cUsername";
	$result = mysql_query($sql,$con);
	if ($result!=false){
		if (mysql_num_rows($result)>0){
			while ($row=@mysql_fetch_array($result)){
				$html .= "<tr>"
					."<td bgcolor='#ffffff' class='normal'>".stripslashes($row["cUsername"])."</td>"
					."<td bgcolor='#ffffff' class='normal'>".stripslashes($row["cRole"])."</td>"
					."<td bgcolor='#ffffff' class='normal'><a href='mailto:".stripslashes($row["cEMail"])."'>".stripslashes($row["cEMail"])."</a></td>"
					."<td bgcolor='#ffffff' class='normal'>";
					
				$html .= "<a href='index.php?action=user_edit&userid=".$row["nUserId"]."'>Edit</a>";
				if ($row["cUsername"]!="admin"){
					$html .= "&nbsp;<a href='index.php?action=user_remove&userid=".$row["nUserId"]."'>Remove</a>";
				}
					
				$html .= "</td>"
					."</tr>\n";
			}
		} else {
			$html .= "<tr><td colspan='4' bgcolor='#ffffff' class='normal' align='center'>There are no users</td></tr>\n";
		}
	} else {
		report_problem(1,"html_user_list ".$sql);
	}
	
	db_disconnect($con);
	
	return $html;
}


// Description : Provides the add user form
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_user_add(){

	$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
		."<tr>"
		."  <td rowspan='2'><img src='images/icon_user.png' width='48' height='52' title='Add User'></td>"
		."  <td class='title'>Add User</div>\n"
		."</tr><tr>"
		."  <td class='normal'>Fill in the blanks in the form below to add a user to the system. As a quick guide, 'Administrators' can do everything in the administration interface, Authors can do everything except modify users, and Contributors can only post new entries.</td>\n"
		."</tr>\n"
		."</table>\n"
		."<br>\n";

	$html .= "<form method='POST' action='exec.php?action=user_add'>\n"
		."<table align='left' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
		."<tr><td colspan='2' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>User Add Form</b></td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Username</td><td bgcolor='#ffffff'><input type='text' name='username' class='text' size='20'></td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Password</td><td bgcolor='#ffffff'><input type='password' name='password' class='text' size='20'></td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>E-Mail</td><td bgcolor='#ffffff'><input type='text' name='email' class='text' size='50'></td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Role</td><td bgcolor='#ffffff'><select name='role' class='text'><option value='admin'>Administrator</option><option value='author'>Author</option><option value='contributor'>Contributor</option></td></tr>\n"
		."<tr><td colspan='2' bgcolor='#ffffff' align='right'><input type='submit' value='Add User' class='button'></td></tr>\n"
		."</table>\n"
		."</form>\n";
		
	return $html;
}


// Description : Provides the user editing form
// Arguments   : userid - the id of the user we want to edit
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_user_edit($userid){
	
	$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
		."<tr>"
		."  <td rowspan='2'><img src='images/icon_user.png' width='48' height='52' title='Edit User'></td>"
		."  <td class='title'>Edit User</div>\n"
		."</tr><tr>"
		."  <td class='normal'>Fill in the blanks in the form below to edit a user in the system. As a quick guide, 'Administrators' can do everything in the administration interface, Authors can do everything except modify users, and Contributors can only post new entries.</td>\n"
		."</tr>\n"
		."</table>\n"
		."<br>\n";
		
	global $db_prefix;
	
	$con = db_connect();
	
	$sql = "SELECT * FROM ".$db_prefix."users WHERE nUserId=".$userid;
	$result = mysql_query($sql,$con);
	if ($result!=false){
		if (mysql_num_rows($result)>0){
			$row =@ mysql_fetch_array($result);
			
			$username = stripslashes($row["cUsername"]);
			$password = stripslashes($row["cPassword"]);
			$email = stripslashes($row["cEMail"]);
			$role = stripslashes($row["cRole"]);
			
			if ($username!="admin"){
				
				switch($role){
					case "administrator":
						$select_administrator = "selected";
						$select_author = "";
						$select_contributor = "";
						break;
					case "author":
						$select_administrator = "";
						$select_author = "selected";
						$select_contributor = "";
						break;
					case "contributor":
						$select_administrator = "";
						$select_author = "";
						$select_contributor = "selected";
						break;
				}
				$html_role_select = "<select name='role' class='text'><option value='admin' ".$select_administrator.">Administrator</option><option value='author' ".$select_author.">Author</option><option value='contributor' ".$select_contributor.">Contributor</option></select>";		
				
			} else {
				
				// this is the admin user
				$html_role_select = "<span class='normal'>Administrator (Fixed)<input type='hidden' name='role' value='admin'></span>";
			}
			
		} else {
			report_problem(2,"html_user_edit");
		}
	} else {
		report_problem(1,"html_user_edit ".$sql);
	}
	
	db_disconnect($con);
	
	$html .= "<form method='POST' action='exec.php?action=user_edit'>\n"
		."<input type='hidden' name='userid' value='".$userid."'>\n"
		."<table align='left' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
		."<tr><td colspan='2' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>User Edit Form</b></td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Username</td><td bgcolor='#ffffff'><input type='text' name='username' class='text' size='20' value='".$username."'></td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Password</td><td bgcolor='#ffffff' class='small'><input type='password' name='user_password' class='text' size='20' value=''>&nbsp;(enter a password to change)</td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>E-Mail</td><td bgcolor='#ffffff'><input type='text' name='email' class='text' size='50' value='".$email."'></td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Role</td><td bgcolor='#ffffff'>".$html_role_select."</td></tr>\n"
		."<tr><td colspan='2' bgcolor='#ffffff' align='right'><input type='submit' value='Make Changes' class='button'></td></tr>\n"
		."</table>\n"
		."</form>\n";
	
	return $html;
	
}


// Description : Provides the user removal form
// Arguments   : userid - the id of the user we want to remove
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_user_remove($userid){

	$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
		."<tr>"
		."  <td rowspan='2'><img src='images/icon_user.png' width='48' height='52' title='Remove User'></td>"
		."  <td class='title'>Remove User</div>\n"
		."</tr><tr>"
		."  <td class='normal'>You have chosen to remove this user. Please check that the user displayed below is correct before clicking on 'Remove User'. Also, make sure you choose an appropriate user to replace this one for 'added by' and 'edited by' data on entries created and changed by this user. Be careful - you cannot undo this operation.</td>\n"
		."</tr>\n"
		."</table>\n"
		."<br>\n";
		
	global $db_prefix;
	
	$con = db_connect();
	
	// create a dropdown for the replaceid
	$sql = "SELECT * FROM ".$db_prefix."users WHERE nUserId<>".$userid." ORDER BY cUsername";
	$result = mysql_query($sql,$con);
	if ($result!=false){
		if (mysql_num_rows($result)>0){
			$html_replace = "<select name='replaceid' class='text'>\n";
			while($row=@mysql_fetch_array($result)){
				$html_replace .= "<option value='".$row["nUserId"]."'>".$row["cUsername"]."</option>\n";
			}
			$html_replace .= "</select>\n";
		} else {
			// problem!
		}
	}
	
	$sql = "SELECT * FROM ".$db_prefix."users WHERE nUserId=".$userid;
	$result = mysql_query($sql,$con);
	if ($result!=false){
		if (mysql_num_rows($result)>0){
			$row =@ mysql_fetch_array($result);
			
			$username = stripslashes($row["cUsername"]);
			$email = stripslashes($row["cEMail"]);
			$role = stripslashes($row["cRole"]);

		} else {
			report_problem(2,"html_user_remove");
		}
	} else {
		report_problem(1,"html_user_remove ".$sql);
	}
	
	db_disconnect($con);

	$html .= "<form method='POST' action='exec.php?action=user_remove&userid=".$userid."'>\n"
		."<table align='left' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
		."<tr><td colspan='2' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>Remove User</b></td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Username</td><td bgcolor='#ffffff' class='normal'>".$username."</td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>E-Mail</td><td bgcolor='#ffffff' class='normal'>".$email."</td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Role</td><td bgcolor='#ffffff' class='normal'>".$role."</td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Replace With</td><td bgcolor='#ffffff' class='normal'>".$html_replace."<span class='small'>&nbsp;(re-assign author of existing entries)</span></td></tr>\n"
		."<tr><td colspan='2' bgcolor='#ffffff' align='right'><input type='submit' value='Remove User' class='button'></td></tr>\n"
		."</table>\n"
		."</form>\n";

	return $html;
}


// Description : Provides the category removal form
// Arguments   : categoryid - the id of the category we want to remove
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_category_remove($categoryid){

	$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
		."<tr>"
		."  <td rowspan='2'><img src='images/icon_categories.png' width='48' height='52' title='Remove Category'></td>"
		."  <td class='title'>Remove Category</div>\n"
		."</tr><tr>"
		."  <td class='normal'>You have chosen to remove this category. Please check that the category displayed below is correct before clicking on 'Remove Category'. Be careful - you cannot undo this operation.</td>\n"
		."</tr>\n"
		."</table>\n"
		."<br>\n";
		
	global $db_prefix;
	
	$con = db_connect();
	
	$sql = "SELECT * FROM ".$db_prefix."categories WHERE nCategoryId=".$categoryid;
	$result = mysql_query($sql,$con);
	if ($result!=false){
		if (mysql_num_rows($result)>0){
			$row =@ mysql_fetch_array($result);
			
			$category_name = stripslashes($row["cCategoryName"]);
			
		} else {
			report_problem(2,"html_category_remove");
		}
	} else {
		report_problem(1,"html_category_remove ".$sql);
	}
	
	db_disconnect($con);

	$html .= "<form method='POST' action='exec.php?action=category_remove&categoryid=".$categoryid."'>\n"
		."<table align='left' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
		."<tr><td colspan='2' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>Remove Category</b></td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Category Name</td><td bgcolor='#ffffff' class='normal'>".$category_name."</td></tr>\n"
		."<tr><td colspan='2' bgcolor='#ffffff' align='right'><input type='submit' value='Remove Category' class='button'></td></tr>\n"
		."</table>\n"
		."</form>\n";

	return $html;
	
}


// Description : Provides the category add form
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_category_add(){

	$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
		."<tr>"
		."  <td rowspan='2'><img src='images/icon_categories.png' width='48' height='52' title='Add Category'></td>"
		."  <td class='title'>Add Category</div>\n"
		."</tr><tr>"
		."  <td class='normal'>Use the form below to add categories to the category list. You can then file entries against the categories.</td>\n"
		."</tr>\n"
		."</table>\n"
		."<br>\n";
		
	$html .= "<form method='POST' action='exec.php?action=category_add'>\n"
		."<table align='left' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
		."<tr><td colspan='2' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>Category Add Form</b></td></tr>\n"
		."<tr><td bgcolor='#ffffff' class='normal'>Category Name</td><td bgcolor='#ffffff'><input type='text' name='category_name' class='text' size='30'></td></tr>\n"
		."<tr><td colspan='2' bgcolor='#ffffff' align='right'><input type='submit' value='Add Category' class='button'></td></tr>\n"
		."</table>\n"
		."</form>\n";
		
	return $html;
}


// Description : Provides the category edit form
// Arguments   : categoryid - the id of the category we want to edit
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_category_edit($categoryid){
	
	$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
		."<tr>"
		."  <td rowspan='2'><img src='images/icon_categories.png' width='48' height='52' title='Edit Category'></td>"
		."  <td class='title'>Edit Category</div>\n"
		."</tr><tr>"
		."  <td class='normal'>Use the form below to edit the category name. Any entries already filed against the category will become filed against the renamed category.</td>\n"
		."</tr>\n"
		."</table>\n"
		."<br>\n";
		
	global $db_prefix;
	
	// get the category record we are editing
	$con = db_connect();
	
	$sql = "SELECT * FROM ".$db_prefix."categories WHERE nCategoryId=".$categoryid;
	$result = mysql_query($sql,$con);
	if ($result!=false){
		if (mysql_num_rows($result)>0){
			$row =@ mysql_fetch_array($result);

			$category_name = stripslashes($row["cCategoryName"]);
			
			$html .= "<form method='POST' action='exec.php?action=category_edit'>\n"
				."<input type='hidden' name='categoryid' value='".$categoryid."'>\n"
				."<table align='left' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
				."<tr><td colspan='2' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>Category Edit Form</b></td></tr>\n"
				."<tr><td bgcolor='#ffffff' class='normal'>Category Name</td><td bgcolor='#ffffff'><input type='text' name='category_name' class='text' size='30' value='".$category_name."'></td></tr>\n"
				."<tr><td colspan='2' bgcolor='#ffffff' align='right'><input type='submit' value='Make Changes' class='button'></td></tr>\n"
				."</table>\n"
				."</form>\n";

		} else {
			// no record
		}
	}

	db_disconnect($con);
	
		
	return $html;
}


// Description : Provides the file browsing form
// Arguments   : None (it uses GET and POST parameters)
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_filebrowse(){

	$site_root = realpath("../.");
	
	$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
		."<tr>"
		."  <td rowspan='2'><img src='images/icon_files.png' width='48' height='52' title='Browse Files'></td>"
		."  <td class='title'>Browse Files</div>\n"
		."</tr><tr>"
		."  <td class='normal'>Use the form below to browse files, upload files and remove files from your system.</td>\n"
		."</tr>\n"
		."</table>\n"
		."<br>\n";
		
	// establish directory we want to show in format /var/html/uploads
	if ($_GET["path"]!=""){
		$path = $_GET["path"];
	} else {
		$path = $site_root."/uploads";
	}

	// clear the file state cache
	clearstatcache();

	if ($handle = opendir($path)) {

		$path = realpath($path);
		
		// Create path in the format http://sitename/filename
		$shortpath = "..".str_replace($site_root,"",$path);
		$i=0;
		while (($file = readdir($handle))!==false) {
			if (is_dir($path."/".$file)){
				// directory
				// exclude path back out of site root
				if ($path==$site_root && $file==".."){
					// exclude
				} else {
					$i++;
					$directories[$i] = $file;
				}
			} else {
				// file
				if ($file!="." && $file!=".."){
					$j++;
					$files[$j] = $file;
				} else {
					// for some reason '..' is detected as a file in safe mode
					if ($path==$site_root && $file==".."){
						// exclude
					} else {
						$i++;
						$directories[$i] = $file;
					}					
				}
			}
		}
		//closedir($handle);

		// sort the arrays
		if (count($directories)>0){
			sort($directories);
		}
		if (count($files)>0){
			sort($files);
		}

		// output the list of directories, then the list of files

		$html .= "<table border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
			."  <tr><td colspan='5' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>File Browse</b></td></tr>\n"
			."  <tr><td colspan='5' bgcolor='#ffffff' class='normal'>Path : ".$path."</td></tr>\n"
			."  <tr><td colspan='5' bgcolor='#ffffff' class='normal'>Create Dir Here : "
			."    <form action='exec.php?action=filebrowse_directory_create' method='POST'>\n"
			."    <input name='path' type='hidden' value='".$path."'>\n"
			."    <input name='shortpath' type='hidden' value='".$shortpath."'>\n"
			."    <input name='directory' type='text' class='text'>\n"
			."    <input class='button' type='submit' value='Create'>\n"
			."    </form>\n"
			."  </td></tr>\n";

		$html .= "  <tr><td colspan='5' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>Directories</b></td></tr>\n";
		for ($i=0;$i<count($directories);$i++){

			// determine controls
			if ($directories[$i]!="." && $directories[$i]!=".."){
				$controls = "<a href='exec.php?action=filebrowse_directory_remove&directory=".$path."/".$directories[$i]."&path=".$path."' class='normal'>Remove</a>";
			} else {
				$controls = "";
			}
			$html.="<tr>"
				."<td bgcolor='#ffffff' width='16'><img src='images/file_icon_folder.png' width='16' height='16'></td>"
				."<td bgcolor='#ffffff' class='normal' colspan='3'><a href='index.php?action=file_browse&path=".$path."/".$directories[$i]."' class='cms_link'>".$directories[$i]."</a></td>"
				."<td bgcolor='#ffffff'>".$controls."</td>"
				."</tr>\n";
		}

		// work out destination for uploads
		$destination = $path;

		$html .= "  <tr><td colspan='5' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>Files</b></td></tr>\n"
			."<tr>"
			."<td bgcolor='#ffffff' class='normal' colspan='5'>Upload Here"
			."    <form enctype='multipart/form-data' action='exec.php?action=filebrowse_file_upload&destination=".$destination."' method='POST'>\n"
			."    <input type='hidden' name='MAX_FILE_SIZE' value='8388608'>\n"
			."    <input name='userfile' type='file' class='text'>\n"
			."    <input class='button' type='submit' value='Send File'>\n"
			."    </form>\n"
			."</td>"
			."</tr>\n"
			."<td width='16' bgcolor='#dddddd' class='cms_small'>&nbsp;</td>"
			."<td bgcolor='#dddddd' class='normal'>Filename</td>"
			."<td bgcolor='#dddddd' class='normal'>Size (Bytes)</td>"
			."<td bgcolor='#dddddd' class='normal'>Size (w x h)</td>"
			."<td bgcolor='#dddddd' class='normal'>Controls</td>"
			."</tr>\n";

		for ($i=0;$i<count($files);$i++){
			// figure out which icon to use
			$controls = "";
			$icon = "";
			switch (strtolower(substr($files[$i],strlen($files[$i])-3,3))){
				case "php":
					$icon = "images/file_icon_script.png";
					$controls = "&nbsp;";
					break;
				case "fnc":
					$icon = "images/file_icon_script.png";
					$controls = "&nbsp;";
					break;
				case "css":
					$icon = "images/file_icon_script.png";
					$controls = "&nbsp;";
					break;
				case ".js":
					$icon = "images/file_icon_script.png";
					$controls = "&nbsp;";
					break;
				case "gif":
					$icon = "images/file_icon_image.png";
					$controls .= "<a href='exec.php?action=filebrowse_file_delete&file=".$path."/".$files[$i]."&path=".$path."' class='normal'>Remove</a>";
					break;
				case "jpg":
					$icon = "images/file_icon_image.png";
					$controls .= "<a href='exec.php?action=filebrowse_file_delete&file=".$path."/".$files[$i]."&path=".$path."' class='normal'>Remove</a>";
					break;
				case "png":
					$icon = "images/file_icon_image.png";
					$controls .= "<a href='exec.php?action=filebrowse_file_delete&file=".$path."/".$files[$i]."&path=".$path."' class='normal'>Remove</a>";
					break;
				case "inc":
					$icon = "images/file_icon_config.png";
					$controls .= "<a href='exec.php?action=filebrowse_file_delete&file=".$path."/".$files[$i]."&path=".$path."' class='normal'>Remove</a>";
					break;
				default:
					$icon = "images/file_icon_script.png";
					$controls .= "<a href='exec.php?action=filebrowse_file_delete&file=".$path."/".$files[$i]."&path=".$path."' class='normal'>Remove</a>";
			}
			// prepare filename (anchor or not)
			if (substr($files[$i],strlen($files[$i])-3,3)=="php" || substr($files[$i],strlen($files[$i])-2,2)=="js"){
				$filename = $files[$i];
			} else {
				$filename = "<a href='".$shortpath."/".$files[$i]."' class='normal'>".$files[$i]."</a>";
			}

			// prepare size if its an image
			if ($files[$i]!="." && $files[$i]!=".."){
				$asize =@ getimagesize($shortpath."/".$files[$i]);
			} else {
				$asize = false;
			}
			if ($asize!=false){
				$size = $asize[0]." x ".$asize[1];
			} else {
				$size = "&nbsp;";
			}

			$html.="<tr>"
				."<td bgcolor='#ffffff' width='16'><img src='".$icon."' width='16' height='16'></td>"
				."<td bgcolor='#ffffff' class='normal'>".$filename."</td>"
				."<td bgcolor='#ffffff' class='normal'>".number_format(filesize($shortpath."/".$files[$i]))."</td>"
				."<td bgcolor='#ffffff' class='normal'>".$size."</td>"
				."<td bgcolor='#ffffff' class='normal'>".$controls."</td>"
				."</tr>\n";
		}

		$html.="</table>\n";

		closedir($handle);
	} else {
		// cannot find uploads directory
	}
	return $html;

}


// Description : Provides the settings form
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_settings_edit(){
	
	// get the settings
	
	$theme = get_setting("theme");
	$crypt_salt = get_setting("crypt_salt");
	$results_per_page = get_setting("results_per_page");
	$entry_list_limit = get_setting("default_entry_list_limit");
	
	$rss_root_url = get_setting("rss_root_url");
	$rss_title = get_setting("rss_title");
	$rss_description = get_setting("rss_description");
	$rss_language = get_setting("rss_language");
	$rss_copyright = get_setting("rss_copyright");
	$rss_editor = get_setting("rss_editor");
	$rss_webmaster = get_setting("rss_webmaster");
	$rss_category = get_setting("rss_category");
	$rss_ttl = get_setting("rss_ttl"); // 60 = default
	
	// set the checked / unchecked status of parse smilies
	$parse_smilies = get_setting("parse_smilies");
	if ($parse_smilies!=""){
		$parse_smilies = "checked";
	}
	
	$html = "<div class='title'>Blog Settings</div>\n"
			."<div class='small'>Use the form below to edit the blog settings.</div>\n"
			."<br>\n";

	$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
		."<tr>"
		."  <td rowspan='2'><img src='images/icon_search.png' width='48' height='52' title='Settings'></td>"
		."  <td class='title'>Settings</div>\n"
		."</tr><tr>"
		."  <td class='normal'>Use the form below to edit the blog settings.</td>\n"
		."</tr>\n"
		."</table>\n"
		."<br>\n";
	
	$html .= "<form method='POST' action='exec.php?action=settings_edit'>\n"
		."<table align='left' border='0' cellspacing='1' cellpadding='3' bgcolor='#cccccc'>\n"
		."<tr><td colspan='2' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>Blog Settings</b></td></tr>\n"
		."<tr>"
		."<td bgcolor='#ffffff' class='normal'>Theme</td>"
		."<td bgcolor='#ffffff'><input type='text' name='theme' class='text' size='60' value='".$theme."'></td>"
		."</tr>\n"
		."<tr>"
		."<td bgcolor='#ffffff' class='normal'>Crypt Salt</td>"
		."<td bgcolor='#ffffff'><input type='text' name='crypt_salt' class='text' size='60' value='".$crypt_salt."'></td>"
		."</tr>\n"
		."<tr>"
		."<td bgcolor='#ffffff' class='normal'>Results Per Page</td>"
		."<td bgcolor='#ffffff'><input type='text' name='results_per_page' class='text' size='60' value='".$results_per_page."'></td>"
		."</tr>\n"
		."<tr>"
		."<td bgcolor='#ffffff' class='normal'>Entry List Limit</td>"
		."<td bgcolor='#ffffff'><input type='text' name='entry_list_limit' class='text' size='60' value='".$entry_list_limit."'></td>"
		."</tr>\n"
		."<tr>"
		."<td bgcolor='#ffffff' class='normal'>Parse Smilies</td>"
		."<td bgcolor='#ffffff'><input type='checkbox' name='parse_smilies' value='x' ".$parse_smilies."></td>"
		."</tr>\n"		
		."<tr><td colspan='2' bgcolor='#cccccc' class='normal' background='images/bg.gif'><b>RSS Settings</b></td></tr>\n"
		."<tr>"
		."<td bgcolor='#ffffff' class='normal'>Root URL</td>"
		."<td bgcolor='#ffffff'><input type='text' name='rss_root_url' class='text' size='60' value='".$rss_root_url."'></td>"
		."</tr>\n"
		."<tr>"
		."<td bgcolor='#ffffff' class='normal'>Blog Title</td>"
		."<td bgcolor='#ffffff'><input type='text' name='rss_title' class='text' size='60' value='".$rss_title."'></td>"
		."</tr>\n"
		."<tr>"
		."<td bgcolor='#ffffff' class='normal'>Description</td>"
		."<td bgcolor='#ffffff'><input type='text' name='rss_description' class='text' size='60' value='".$rss_description."'></td>"
		."</tr>\n"
		."<tr>"
		."<td bgcolor='#ffffff' class='normal'>Language</td>"
		."<td bgcolor='#ffffff'><input type='text' name='rss_language' class='text' size='10' value='".$rss_language."'></td>"
		."</tr>\n"
		."<tr>"
		."<td bgcolor='#ffffff' class='normal'>Copyright</td>"
		."<td bgcolor='#ffffff'><input type='text' name='rss_copyright' class='text' size='50' value='".$rss_copyright."'></td>"
		."</tr>\n"
		."<tr>"
		."<td bgcolor='#ffffff' class='normal'>Editor</td>"
		."<td bgcolor='#ffffff'><input type='text' name='rss_editor' class='text' size='50' value='".$rss_editor."'></td>"
		."</tr>\n"
		."<tr>"
		."<td bgcolor='#ffffff' class='normal'>Webmaster</td>"
		."<td bgcolor='#ffffff'><input type='text' name='rss_webmaster' class='text' size='50' value='".$rss_webmaster."'></td>"
		."</tr>\n"
		."<tr>"
		."<td bgcolor='#ffffff' class='normal'>Category</td>"
		."<td bgcolor='#ffffff'><input type='text' name='rss_category' class='text' size='30' value='".$rss_category."'></td>"
		."</tr>\n"
		."<tr>"
		."<td bgcolor='#ffffff' class='normal'>TTL</td>"
		."<td bgcolor='#ffffff'><input type='text' name='rss_ttl' class='text' size='10' value='".$rss_ttl."'></td>"
		."</tr>\n"
		."<tr><td colspan='2' bgcolor='#ffffff' align='right'><input type='submit' value='Make Changes' class='button'></td></tr>\n"
		."</table>\n"
		."</form>\n";
		
	return $html;
	
}


// Description : Provides the forbidden screen
// Arguments   : None
// Returns     : HTML
// Last Change : 2005-09-13 22:00
// Author      : Jonathan Beckett (jonbeckett@pluggedout.com)
function html_forbidden(){

	$html = "<table border='0' cellspacing='0' cellpadding='2'>\n"
		."<tr>"
		."  <td rowspan='2'><img src='images/icon_help.png' width='48' height='52' title='Forbidden'></td>"
		."  <td class='title'>Forbidden</div>\n"
		."</tr><tr>"
		."  <td class='normal'>You have requested a section of the administration interface that you do not have sufficient privilages to access.</td>\n"
		."</tr>\n"
		."</table>\n"
		."<br>\n";
		
	return $html;
	
}
?>