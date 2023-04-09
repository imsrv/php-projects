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
include_once('inc/adodb300/adodb.inc.php');	   # load code common to ADOdb
include_once('config.php');
include_once('inc/UIfunctions.php');

showHeader($siteName);

#
# Table structure for table `cardinfo`
#

$cardinfoSQL= "
CREATE TABLE cardinfo (
  imageid int(11) NOT NULL auto_increment,
  cardname varchar(40) NOT NULL default '',
  catid int(11) default NULL,
  imagepath varchar(40) NOT NULL default '',
  thumbpath varchar(40) NOT NULL default '',
  senttimes int(11) NOT NULL default '0',
  PRIMARY KEY  (imageid)
) TYPE=MyISAM;";
# --------------------------------------------------------

#
# Table structure for table `cardusers`
#

$cardusersSQL= "
CREATE TABLE cardusers (
  userid int(11) NOT NULL auto_increment,
  username varchar(40) NOT NULL default '',
  userpass varchar(40) NOT NULL default '',
  email varchar(60) default NULL,
  role varchar(20) default NULL,
  PRIMARY KEY  (userid)
) TYPE=MyISAM;";
# --------------------------------------------------------

#
# Table structure for table `categories`
#
$categoriesSQL = "
CREATE TABLE categories (
  catid int(11) NOT NULL auto_increment,
  category varchar(60) NOT NULL default '',
  PRIMARY KEY  (catid)
) TYPE=MyISAM;";
# --------------------------------------------------------

#
# Table structure for table `sentcards`
#
$sentcardsSQL = "
CREATE TABLE sentcards (
  cardid int(11) NOT NULL default '0',
  imageid int(11) NOT NULL default '0',
  to_name varchar(60) default NULL,
  to_email varchar(60) NOT NULL default '',
  from_name varchar(60) default NULL,
  from_email varchar(60) NOT NULL default '',
  cardtext mediumtext,
  sendonpickup varchar(10) default NULL,
  PRIMARY KEY  (cardid)
) TYPE=MyISAM;";

#
# Insert admin user into `cardusers`
#
$adminSQL = "INSERT INTO cardusers (username, userpass, email, role) VALUES ('admin',password('admin'),'email','admin')";

#
# Insert 'test' category into `categpories`
#
$testcatSQL = "INSERT INTO categories (category) VALUES ('test')";


// --------------------------------------------------------------------

$success = "<td bgcolor=\"#33cc33\"><img src=\"images/siteImages/shim.gif\" border=\"0\" width=\"10\"></td>";
$failure = "<td bgcolor=\"#FF0000\"><img src=\"images/siteImages/shim.gif\" border=\"0\" width=\"10\"></td>";

echo "<table cellspacing=\"5\" width=\"500\">";

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
if (!($conn = &ADONewConnection('mysql')))
	echo "<tr>$failure<td>Could not connect to MySQL</td></tr>";
if (!($conn->Connect($dbhost,$dbuser,$dbpass,$dbdatabase)))
	echo "<tr>$failure<td>Could not connect to the selected database.  Check the config.php file to be sure you set the correct database server, database name, username, and password.  Contact your system administrator if you do not know these values.</td></tr>";



if (!($conn->execute($cardinfoSQL)))
	echo "<tr>$failure<td>Could not add cardinfo table!</td></tr>";
else
	echo "<tr>$success<td>Successfully added cardinfo table</td></tr>";

if (!($conn->execute($cardusersSQL)))
	echo "<tr>$failure<td>Could not add cardusers table!</td></tr>";
else
	echo "<tr>$success<td>Successfully added cardusers table</td></tr>";

if (!($conn->execute($categoriesSQL)))
	echo "<tr>$failure<td>Could not add categories table!</td></tr>";
else
	echo "<tr>$success<td>Successfully added categories table</td></tr>";
	
if (!($conn->execute($sentcardsSQL)))
	echo "<tr>$failure<td>Could not add sentcards table!</td></tr>";
else
	echo "<tr>$success<td>Successfully added sentcards table</td></tr>";

if (!($conn->execute($adminSQL)))
	echo "<tr>$failure<td>Could not add admin user!</td></tr>";
else
	echo "<tr>$success<td>Username: 'admin' Password: 'admin' added to database.</td></tr>";

if (!($conn->execute($testcatSQL)))
	echo "<tr>$failure<td>Could not add 'test' category!</td></tr>";
else
	echo "<tr>$success<td>Category: 'test' added to database</td></tr>";

if (!(chmod("images", 0777)))
	echo "<tr>$failure<td>Could not CHMOD 'images' directory to '777' - you will have to do this manually.</td></tr>";
else
	echo "<tr>$success<td>Successful CHMOD of 'images' directory to '777'.  Please disregard step 1 below.</td></tr>";
	
echo "</table>";
?>
<table cellspacing="5" width="500">
	<tr>
		<td class="bold" colspan="2">Setup Steps</td>
	</tr>
	<tr>
		<td valign="top">1</td>
		<td>CHMOD the 'images' folder to '777' if you have not already done so.</td>
	</tr>
	<tr>
		<td valign="top">2</td>
		<td>Please login to the <a href="login.php" target="_blank">Administration Console</a>.  This will launch in a separate window so you can keep these instructions in the browser.</td>
	</tr>
	<tr>
		<td valign="top">3</td>
		<td>Once logged in, please change the password to the 'admin' account for security purposes.</td>
	</tr>
	<tr>
		<td valign="top">4</td>
		<td>Add categories in the Category Maintenance section.</td>
	</tr>
	<tr>
		<td valign="top">5</td>
		<td>Add new eCards via the Card Maintenance section.</td>
	</tr>
	<tr>
		<td valign="top">6</td>
		<td>Delete setup.php or CHMOD it to '000' to prevent malicious users from modifying this application</td>
	</tr>
	<tr>
		<td valign="top">7</td>
		<td>Launch <a href="index.php">index.php</a> to see your eCard site!</td>
	</tr>
	<tr>
		<td valign="top">8</td>
		<td>DONE!</td>
	</tr>
</table>

<br><br>Please login to the <a href="login.php" target="_blank">Administration Console</a> to add new cards and categories.  Be sure to change the admin password for security purposes.
<?
	
showFooter();
?>
