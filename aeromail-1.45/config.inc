<?php

//    AeroMail - a web-based e-mail client written in PHP
//    Copyright (C) 2000  Mark Cushman
//
//    This program is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program; if not, write to the Free Software
//    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.

//-----------------------
// server config section
//-----------------------

// controls the name at the top of the window
$PROG_NAME		= "AeroMail";

// directory for folders to be stored - applies to UWash servers only
// if server type is Cyrus, this var is not used
$PROG_DIR		= ".aeromail/";

// this is the server name or ip address of the IMAP server
$IMAP_SERVER 		= "localhost";

// server type should either be "Cyrus" or "UWash"
$IMAP_SERVER_TYPE 	= "UWash";

// tcp port where the IMAP server is running - default is 143
$IMAP_PORT		= "143";

// url to redirect to when a user clicks on cancel when loggin in
$SERVER_REDIR		= "http://the.cushman.net/";

// default number of messages to display per screen
$MSG_COUNT		= 15;

// should AeroMail decide what the user's e-mail address is, or should
// AeroMail let sendmail and genericstable figure it out (0=no 1=yes)
$FORCE_FROM		= 0;

// default folder to store sent messages in
// set to 0 to disable sent mail storage
$SENT_MAIL		= "Sent Mail";

//------------------------
// user interface section
//------------------------

// change the path to this file to the desired theme file
include("themes/default.theme.inc");

//------------------
// language section
//------------------

// change the path to this file to the desired language file
include("lang/en.lang.inc");

?>
