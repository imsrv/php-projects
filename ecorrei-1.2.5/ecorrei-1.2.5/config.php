<?php
/*	eCorrei 1.2.5 - Configure script
	A webbased E-mail solution
	Page: http://ecorrei.sourceforge.net/
	Date: 2 February 2002
	Author: Jeroen Vreuls
	Copyright (C) 2000-2002 Jeroen Vreuls

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
	or see http://www.fsf.org/copyleft/gpl.html
*/

/* ECORREI CONFIGURATION */


/* PATHS AND DIRECTORIES */

/* eCorrei dir
   Path to use in URL's to point to the eCorrei directory
   Include a trailing slash
*/
$cfg->ecorreidir = "/ecorrei/";

/* Image dir
   Path to use in URL's to point to the eCorrei images directory
   Include a trailing slash
*/
$cfg->imgdir = "/ecorrei/images/";

/* User path (where user settings are stored)
   See SECURITY for details
   Can be relative to current dir or can be absolute path
   Must be chmodded 777, include a trailing slash  
*/
$cfg->userpath = "users/";

/* Temp dir (where attachments are temporarily stored)
   Can be relative to current dir or can be absolute path
   If it is "" then 'upload_tmp_dir' from php.ini is used
   (it must be set if you want to use it!)
   Must be chmodded 777, include a trailing slash  
*/
//$cfg->tmpdir = "temp/";

/* Languages path (where language files are stored)
   Can be relative to current dir or can be absolute path
   Include a trailing slash
*/
$cfg->langdir = "lang/";


/* NETWORK SETTINGS */

/* Domain arrays
   name: string behind the "@" in the address
   inmailserver: mail server, e.g: "localhost"
   accessmethod: imap or pop3
   inmailport: mail server port
   outmail: smtp server, e.g: "localhost"
   set outmail to "__none__" (without the quotes)
   to send mail using the standard PHP mail() function
   append: string to append after the username given
   by user to form a login username
*/
$domains[0]->name = "foobar.com";
$domains[0]->inmailserver = "mail.foobar.com";
$domains[0]->accessmethod = "imap";
$domains[0]->inmailport = 143;
$domains[0]->outmailserver = "smtp.foobar.com";
$domains[0]->outmailport = 25;
$domains[0]->append = "";

$domains[1]->name = "foobar.org";
$domains[1]->inmailserver = "mail.foobar.org";
$domains[1]->accessmethod = "pop3";
$domains[1]->inmailport = 110;
$domains[1]->outmailserver = "__none__";
$domains[1]->outmailport = 25;
$domains[1]->append = "";

/* Hostname for eCorrei computer
   Most of the time this is $HTTP_HOST, but you can set it
   manually here
*/
$cfg->hostname = $HTTP_HOST;

/* Protocol
   Which protocol to use: http or https (for secure connections)
*/
$cfg->protocol = "http";


/* DEFAULTS */

/* Default sort in Inbox
   Can be:
   SORTDATE: message date
   SORTARRIVAL: arrival date
   SORTFROM: from emailaddress (note that the emailaddress
   isn't displayed in the Inbox most of the time)
   SORTSUBJECT: message subject
   SORTTO: to emailaddress
   SORTCC: cc emailaddress
   SORTSIZE: size of message
*/
$cfg->default_sort = SORTARRIVAL;

/* Default sort direction
   0: from low to high
   1: from high to low
*/
$cfg->default_direction = 1;

/* Default timezone
   This is the default time offset
   to the GMT time. Users can change
   this value in the Options
   This must be in minutes
*/
$cfg->default_timezone = 60;

/* Default language to use
   See languages below
*/
$cfg->default_lang = "en";


/* MISCELLANEOUS OPTIONS */

/* Whether to display eCorrei host or not in sent mails
   Will add "X-eCorrei-Host:" to each sent mail
   Set to 1 for add the field, 0 to remove the field
*/
$cfg->showhost = 1;

/* Maximum size of settings file
   (user settings & addressbook file)
   in bytes
*/
$cfg->maxfilesize = 51200;

/* Maximum size of files that can be attached
   to a mail
   in bytes
*/
$cfg->maxmailsize = 2097152;

/* Text to add to every message sent with eCorrei
   Remember to start with at least one newline, to prevent
   it from messing up your messages
   Set to "" to disable
*/
$cfg->msgsignature = "\n\n___________________________________________\nSent with eCorrei - http://ecorrei.sf.net/";

/* Refresh time of Inbox
   After this amount of seconds, the
   Inbox will be refreshed automatically
*/
$cfg->refreshtime = 180;

/* Allow from change
   Determines whether to allow users to change
   their From: e-mailaddress on the options
   page
   1 to allow, 0 to deny
*/
$cfg->allowfromchange = 1;

/* APPEARANCE */

/* HTML code that is inserted right after the <body> of every page */
$cfg->htmlpre = "";

/* HTML code that is inserted before the </body> tag of every page */
$cfg->htmlfooter = "";

/* Background color of all pages */
$cfg->bgcolor = "#FFFFFF";

/* Background color of messages */
$cfg->msgbgcolor = "#FFFFFF";

/* Titlebar color */
$cfg->titlebarcolor = "#000080";

/* Titlebar text color */
$cfg->titlebartxtcolor = "#FFFFFF";

/* Window background color */
$cfg->windowbgcolor = "#C0C0FF";

/* Dark bar color */
$cfg->darkbarcolor = "#8080FF";

/* Inbox color for normal messages */
$cfg->inbxnormal = "#E6E6FF";

/* Inbox color for new messages */
$cfg->inbxnew = "#C0C0FF";

/* LANGUAGES */

/* Doesn't need to be configured */

$languages[0]->name = "Dansk";
$languages[0]->code = "da";

$languages[1]->name = "Deutsch";
$languages[1]->code = "de";

$languages[2]->name = "English";
$languages[2]->code = "en";

$languages[3]->name = "Français";
$languages[3]->code = "fr";

$languages[4]->name = "Nederlands";
$languages[4]->code = "nl";

$languages[5]->name = "Português Brasileiro";
$languages[5]->code = "pt-br";

$languages[6]->name = "Russian";
$languages[6]->code = "ru";

$languages[7]->name = "Svenska";
$languages[7]->code = "se";

?>
