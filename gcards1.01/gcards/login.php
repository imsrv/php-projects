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
if (session_is_registered("auth_user"))
{
	Header ("Location: admin/admin.php");
}

include_once('config.php');
include_once('inc/UIfunctions.php');
showHeader('eCards Administration Console Login','',1,0,1);

?>
<table>
<form name="loginform" action="admin/admin.php" method="POST">
	<tr>
		<td>Username:</td>
		<td><input type="text" name="username"></td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><input type="password" name="userpass"></td>
	</tr>
	<tr>
		<td colspan="2" align="right"><input type="submit" value="Login"></td>
	</tr>	
</form>
</table>

</body>
</html>
