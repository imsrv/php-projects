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
include_once('loginfunction.php');
include_once('../config.php');
include_once('../inc/UIfunctions.php');


if (!session_is_registered("auth_user"))
	loginuser();

showHeader('eCards Administration Console', '../');
?>

<table>
	<tr>
		<td class="bold">Administrative Options</td>
	</tr>
	<tr>
		<td><a href="cards.php">Card Maintenance</a> - View, add, update, and delete cards</td>
	</tr>
	<tr>
		<td><a href="categories.php">Category Maintenance</a> - View, add, update, and delete categories</td>
	</tr>
<?
	if ($auth_role == 'admin')
{
?>
	<tr>
		<td><a href="users.php">User Maintenance</a> - View, add, update, and delete users accounts</td>
	</tr>
<?
}
?>
</table>



<?
showFooter();
?>
