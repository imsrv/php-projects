<?

//******************************************************************************
/*
GPL Copyright Notice

Relata
Copyright (C) 2001 Stratabase, Inc.

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/
//******************************************************************************

include("../config.inc.php");

//  We use the following features:
//  sess   for session variables
//  auth   for login checks, also required for user variables

// perform all startup functions
page_open(array(
	"sess" => "relata_session", 
	"auth" => "relata_challenge_auth"
	));

// start a new template
$template = start_template();

$template->set_file("main", "group_email_toolbar.htm");

$template->set_var("WWW_DIR",$_PHPLIB['webdir']);

$template->parse("output","main");
$template->p("output");

page_close();

?>