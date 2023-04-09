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

/*
*********************************************
*   eCard Application Info                  *
*********************************************
*/

$sitePath = "http://www.hostname.com/gcards"; // needed to create url for eCard pickup.  Please leave off trailing slash.
$siteName = "Graphics by Greg gCards"; // name shown in upper left corner of site and in emails
$siteEmail = "ecards@hostname.com";  // 'From' email address shown in notification email
$deleteDays = 14;  // Delete sent cards after this number of days.  Set to 0 to not delete values

/*
*********************************************
*   Database Properties                     *
*********************************************
*/

$dbhost = 'localhost';	// database host
$dbuser = 'username';		// database user name
$dbpass = 'password';		// database user password
$dbdatabase = 'gcards';	// database with eCards tables

/*
*********************************************
*   Display Options                         *
*********************************************
*/

$cardsPerRow = 3;  // number of cards shown per row on the index.php page
$rowsPerPage = 2;
$order = 'ASC';		// 'ASC' or 'DESC' - set DESC to show most recently added cards first


/*
*********************************************
*   Email Text                              *
*********************************************
*/
$subject = "eCard from $from_name!";
$message =	" $from_name has sent you an eCard!\r\nYou can pick it up at the following address:\r\n\r\n$sitePath/getcard.php?cardid=$cardid";

/*
*********************************************
*   Card Options                              *
*********************************************
*/

$maxFileSize = 250; // Maximum image size allowed in upload (measured in KiloBytes)
$resize_height = 100; // Height of generated thumbnails
$imagequality = 75; // Quality of thumbnails.  Range 0-100


?>
