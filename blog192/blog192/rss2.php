<?php
/*
#===========================================================================
#= Project: PluggedOut Blog
#= File   : rss2.php
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

function sql_to_rss_date($sql_date){

	$timestamp = strtotime($sql_date);
	
	// create the output value
	// example - Fri, 30 May 2003 11:06:42 GMT
	$result = date("D, d M Y H:i:s T",$timestamp);
	
	return $result;
}

// get settings
$rss_root_url = get_setting("rss_root_url");
$rss_title = get_setting("rss_title");
$rss_description = get_setting("rss_description");
$rss_link = get_setting("rss_link");
$rss_language = get_setting("rss_language");
$rss_copyright = get_setting("rss_copyright");
$rss_editor = get_setting("rss_editor");
$rss_webmaster = get_setting("rss_webmaster");
$rss_category = get_setting("rss_category");
$rss_ttl = get_setting("rss_ttl"); // 60 = default

// connect to the database
$con = db_connect();

// get the last 20 entries
$sql = "SELECT * FROM ".$db_prefix."entries ORDER BY dAdded DESC LIMIT 20";
$result = mysql_query($sql,$con);

if ($result!=false){

	// Build the header of the RSS file
	$pub_date = date("D, d M Y H:i:s T");
	$last_build_date = date("D, d M Y H:i:s T");
	$rss = "<rss version=\"2.0\" xmlns:content=\"http://purl.org/rss/1.0/modules/content/\">\n"
		."<channel>\n"
		."<title>".$rss_title."</title>\n"
		."<description>".$rss_description."</description>\n"
		."<link>".$rss_root_url."</link>\n"
		."<language>".$rss_language."</language>\n"
		."<copyright>".$rss_copyright."</copyright>\n"
		."<managingEditor>".$rss_editor."</managingEditor>\n"
		."<webMaster>".$rss_webmaster."</webMaster>\n"
		."<pubDate>".$pub_date."</pubDate>\n"
		."<lastBuildDate>".$last_build_date."</lastBuildDate>\n"
		."<category>".$rss_category."</category>\n"
		."<generator>PluggedOut Blog 2.x</generator>\n"
		."<docs>http://blogs.law.harvard.edu/tech/rss</docs>\n"
		."<ttl>".$rss_ttl."</ttl>\n";

	// Build the news entries		
	if (mysql_num_rows($result)>0){

		while ($row=@mysql_fetch_array($result)){
		
			//prepare data
			
			$title = htmlentities(stripslashes($row["cTitle"]));
			$first_para = htmlentities(stripslashes($row["cBody"]));
			
			$content = htmlentities(stripslashes($row["cBody"]));
			
			$entryid = $row["nEntryId"];
			$item_pub_date = sql_to_rss_date($row["dAdded"]);
		
			$rss .= "<item>\n"
				."<title>".$title."</title>\n"
				."<link>".$rss_root_url."/index.php?entryid=".$entryid."</link>\n"
				."<description>".$first_para."</description>\n"
				."<content:encoded><![CDATA[".$content."]]></content:encoded>\n"
				."<author>".$entry_email."</author>\n"
				."<category>".$rss_category."</category>\n"
				."<comments>".$rss_root_url."/index.php?entryid=".$entryid."</comments>\n"
				."<guid>".$rss_root_url."/index.php?entryid=".$entryid."</guid>\n"
				."<pubDate>".sql_to_rss_date($item_pub_date)."</pubDate>\n"
				."<source url=\"".$rss_root_url."/rss2.php\">".$rss_title."</source>\n"
				."</item>\n";
			
		}		
	}
	
	$rss .= "</channel>\n"
		."</rss>\n";
}

db_disconnect($con);

header("content-type:text/xml;encoding:UTF-8");
print $rss;

?>