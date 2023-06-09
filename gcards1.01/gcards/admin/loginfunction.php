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
function loginuser()
{
	global $username;
	global $userpass;
	if ($username && $userpass)
	{
		include('../inc/adodb300/adodb.inc.php');	   # load code common to ADOdb
		include('../config.php');
		$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
		$conn = &ADONewConnection('mysql');	# create a connection
		$conn->Connect($dbhost,$dbuser,$dbpass,$dbdatabase);
		$sqlstmt = "SELECT * FROM cardusers WHERE username='$username' AND userpass=password('$userpass')";
		$recordSet = &$conn->Execute("$sqlstmt" );
		$numResults = $recordSet->RecordCount();
		$userRole = $recordSet->fields[role];
		if ($numResults > 0)
			{
				$auth_user = $username;
				session_register('auth_user');
				$GLOBALS['auth_user'] = $username;
				session_register('auth_role');
				$GLOBALS['auth_role'] = $userRole;
			}
		else
			{
				showHeader('eCards Administration Console', '../');
				echo "Authentication failed for user: $username.  Please <a href=\"../login.php\">try again</a>";
				showFooter();
				exit;
			}
	}
	else 
	{
		showHeader('eCards Administration Console', '../');
		echo "Please enter both a username and passord.  Please <a href=\"../login.php\">try again</a>";
		showFooter();
		exit;
	}
}

function checkUser($check='')
{
	global $auth_user;
	global $auth_role;
	if (!(session_is_registered("auth_user")))
	{
		showHeader('eCards Administration Console', '../');
		echo "You are not logged in!<br>";
		echo "Please <a href=\"../login.php\">Login</a><br>";
		showFooter();
		exit;
	}
	if ($check)
	{
		if (!($auth_role == $check))
		{
			showHeader('eCards Administration Console', '../');
			echo "You do not have sufficient privileges to view this page!<br>";
			showFooter();
			exit;	
		}
	}
}
?>
