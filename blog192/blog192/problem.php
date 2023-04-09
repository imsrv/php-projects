<?php
/*
#===========================================================================
#= Project: PluggedOut Blog
#= File   : problem.php
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

switch ($_REQUEST["id"]){
	case "1":
		// database result error
		print "Problem with Database Result Code<br><br>".$_REQUEST["data"];
		break;
	case "2":
		// no records returned
		break;
	case "3":
		// no data?
		break;
}

print "<li><a href='index.php'>Home</a></li>\n";

?>