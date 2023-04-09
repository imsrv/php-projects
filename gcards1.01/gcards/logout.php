<?
/*
 * gCards - a web-based eCard application
 * Copyright (C) 2003 Greg Neustaetter
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
session_start();
include_once('inc/UIfunctions.php');
include_once('config.php');



if (!(session_is_registered("auth_user")))
{
	showHeader('eCards Administration Console Logout');
	echo "You are not logged in - you cannot logout!";
	showFooter();
	exit;
}

if (!(session_unregister('auth_user')))
{
	showHeader('eCards Administration Console Logout');
	echo "Could not logout of application!";
	showFooter();
	exit;
}

showHeader('eCards Administration Console Logout');

echo "Successfully logged out of application...<br>";

showFooter();
?>
