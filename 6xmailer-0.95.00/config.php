<?php
// =============================================================================
//	6XMailer - A PHP POP3 mail reader.
//	Copyright (C) 2001  6XGate Systems, Inc.
//	
//	This program is free software; you can redistribute it and/or
//	modify it under the terms of the GNU General Public License
//	as published by the Free Software Foundation; either version 2
//	of the License, or (at your option) any later version.
//	
//	This program is distributed in the hope that it will be useful,
//	but WITHOUT ANY WARRANTY; without even the implied warranty of
//	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//	GNU General Public License for more details.
//	
//	You should have received a copy of the GNU General Public License
//	along with this program; if not, write to the Free Software
//	Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
// ==============================================================================

// ===========================================================================
//	6XMail Configuation Script/File
//	All settings concerning the mailer should be set here and not by modifying
//	the scripts themselves.
// ===========================================================================

// Server information
// -------------------------------------------------------------
// These variables contain the server's hostname (or IP address)
// and port to connect to the server as well as the domain part
// (behind the @) to add to e-mail addresses.

$POPHostname = "localhost";
$POPPort = "110";				// POP3 default is 110
$POPDomain = "sixxgate.ath.cx";

// Demo mode
// -----------------------------------------------------
// This will tell the server to disable certain feature
// such as sending mail, the address book, and per user
// customizations.
$DemoMode = false;

// Text Strings
// -----------------------------------------------------
// These are messages and formats that you can customize

$MailSystemTitle = "PHP Web Mailer";
$QuoteInReply = "----Original Message----";
$FileTooBig = "The file attachment you tries to send was too big for this mailer.  This limit is set by the administrator, Sorry.";

// Language
// ---------------------------------------------------
// This helps to determine the language strings to use

$Language = "English";

// Theme
// --------------------------------------------------------
// The theme to use (sytle sheets and configuration strips)

$Theme = "default";

// Refresh time
// ------------------------------------------------------------------
// The number of seconds for the list page to wait before automaticly
// refreshing itself.
$RefreshList = "600";  // The default is 10 minutes (600 seconds)

// File Attachment Size Limite
// ------------------------------------------------------------------
// This lets the administrator limit the size of the files that can
// be attached to mail.  If this size ends in a "M", or "k" then the
// the size will be based on a Megabyte or kilobyte.  If no ending
// exists then the size is in bytes.  The ending is case insensitive.
// No setting or a setting of 0 with any ending means no limit.
$AttachmentSize = "1M";

// Database Information
// ------------------------------------------------------------------
// These settings contain information on the database name and stuff.
// This is for mySQL only.
$QLPort = "3306";
$QLHostname = "localhost";
$QLSocket = "";
$QLUsername = "username";
$QLPassword = "password";
$QLDatabase = "6xmailer_data";
?>
