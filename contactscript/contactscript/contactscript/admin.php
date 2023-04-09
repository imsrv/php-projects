<?php
// like i said, we must never forget to start the session
session_start();

// is the one accessing this page logged in or not?
if (!isset($_SESSION['basic_is_logged_in'])
    || $_SESSION['basic_is_logged_in'] !== true) {

    // not logged in, move to login page
    header('Location: login.php');
    exit;
}

?><!--//
*********************************************************************************   
*********************************************************************************   
**  a script that you enter your myspace url and ms user idit creates a code   **
**          so that users can place a contact box on there website             **
**      Copyright (C) 2005  <Mark Beard markbeardwebdesign@gmail.com>          **
**                                                                             **
**     This program is free software; you can redistribute it and/or modify    **  
**     it under the terms of the GNU General Public License as published by    **  
**       the Free Software Foundation; either version 2 of the License, or     **  
**                     (at your option) any later version.                     **  
**                                                                             **  
**         This program is distributed in the hope that it will be useful,     **  
**         but WITHOUT ANY WARRANTY; without even the implied warranty of      **  
**          MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the      **  
**              GNU General Public License for more details.                   **  
**                                                                             **  
**        You should have received a copy of the GNU General Public License    **  
**        along with this program; if not, write to the Free Software          **  
**  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA  **   
*********************************************************************************
********************************************************************************* //--><? include "config.php" ?> 
<style type="text/css">
<!--
body {
	margin-top: 0px;
	margin-bottom: 0px;
}
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #000000;
}
.style1 {color: #FFFFFF}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
.style2 {
	color: #FFFFFF;
	font-weight: bold;
}
.style3 {
	color: #003399;
	font-weight: bold;
}
.style4 {color: #CC0000}
.style5 {color: #FF6600}
-->
</style>
<title>MyspaceOutfit.com - Dress up your Myspace</title><table width="800" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#003399"><img src="artwork/header.gif"></td>
      </tr>
      <tr>
        <td bgcolor="#6698CB"><table width="800" border="0" cellspacing="2" cellpadding="0">

          <tr>
            <td><table width="650" border="0" align="left" cellpadding="5" cellspacing="0">
              <tr>
                <td><div align="center"><a href="index.php" class="style1">Home</a></div></td>
                <td><div align="center">|</div></td>
                <td><div align="center"><a href="frame.php?pg=printer.php" target="_blank" class="style1">Print List</a></div></td>
                <td><div align="center">|</div></td>

                <td><div align="center"><a href="frame.php?pg=http://myspaceoutfit.com" target="_blank"  class="style1">Myspace Outfit</a></div></td>
                <td><div align="center">|</div></td>
                <td><div align="center"><a href="frame.php?pg=http://myspace.com" target="_blank"  class="style1">Myspace</a></div></td>
<td><div align="center">|</div></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr></table><br><table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#cccccc"><? include "http://myspaceoutfit.com/mscontact/News.txt" ?></td>
      </tr></table><br><table width=100% border=1 cellspacing=0 cellpadding=0>
               <tr>
                <td width=15><center><font color=#000000>#</font></center></td>
    <td width=100><center><font color=#000000>Date & Time</font></center></td>
    <td width=400><center><font color=#000000>ID</font></center></td>       
               
    <td width=150 bgcolor=#BCFF79><center><font color=#000000>Visit There MySpace</font></center></td>
    <td width=150 bgcolor=#FF7575><center><font color=#000000>Add To Friends</font></center></td>
  </tr></table><?php


//connect to server and select database
$conn = mysql_connect("$dbhost", "$dbuname", "$dbpass") or die(mysql_error());
mysql_select_db("$dbname",$conn)  or die(mysql_error());

        //load all news from the database and then OREDER them by newsid
        //you will notice that newlly added news will appeare first.
        //also you can OREDER by (dtime) instaed of (news id)
        $result = mysql_query("SELECT * FROM users ORDER BY id DESC");
        //lets make a loop and get all news from the database
        while($myrow = mysql_fetch_array($result))
             {//begin of loop
               //now print the results:
               echo "<table width=100% border=1 cellspacing=0 cellpadding=4>
             
           
  <tr>
    <td width=10 bgcolor=#D8D8D8><b>";
               echo $myrow['id'];
               echo "</b></td>
               <td width=100 bgcolor=#D8D8D8>";
               echo $myrow['time'];
               echo "</td>
                 <td width=400 bgcolor=#D8D8D8>";
               echo $myrow['ms'];
               echo "</td>
               
    <td width=150 bgcolor=#BCFF79><center><a href=\"frame.php?pg=$myrow[url]\" target='_blank'><font color=#000000>Visit There MySpace</font></a></center></td>
    <td width=150 bgcolor=#FF7575><center><a href=\"http://www.myspace.com/index.cfm?fuseaction=invite.addfriend_verify&friendID=$myrow[ms]\" target='_blank'><font color=#000000>Add To Friends</font></a></center></td>
  </tr>
  <tr>   <td width=10 bgcolor=#D8D8D8><b>";
               
               echo "</b></td><td width=100 bgcolor=#D8D8D8>";
             
               echo "</td><td width=400 bgcolor=#D8D8D8>";
               echo $myrow['url'];
               echo "</td>
  </tr>
</table><br>";
             }//end of loop
?>
 <p><a href="index.php">Home</a></p> <p><a href="logout.php">Logout</a> </p>

<? include "footer.php" ?>

