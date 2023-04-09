<!--//
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
********************************************************************************* //--><?
$url = "$_POST[url]";
$ms = "$_POST[id]";
$group = "$_POST[group]"; ?>




<? include "config.php" ?> <?php


//connect to server and select database
$conn = mysql_connect("$dbhost", "$dbuname", "$dbpass") or die(mysql_error());
mysql_select_db("$dbname",$conn)  or die(mysql_error());


//create and issue the second query
$add_post = "insert into users values ('', now(),'$url','$ms')";
mysql_query($add_post,$conn) or die(mysql_error());

?>

<!-- TWO STEPS TO INSTALL SELECT AND AUTO COPY:

  1.  Copy the coding into the HEAD of your HTML document
  2.  Add the last code into the BODY of your HTML document  -->

<!-- STEP ONE: Paste this code into the HEAD of your HTML document  -->

<HEAD>

<SCRIPT LANGUAGE="JavaScript">

<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->
<!-- Original:  Russ (NewXS3@aol.com) -->
<!-- Web Site:  http://dblast.cjb.net -->

<!-- Begin
function copyit(theField) {
var tempval=eval("document."+theField)
tempval.focus()
tempval.select()
therange=tempval.createTextRange()
therange.execCommand("Copy")
}
//  End -->
</script>
<a href="<?=$url?>"><img
 src="http://viewmorepics.myspace.com/images/banner_130x55_03.gif"></a><br>
</div>
<a
 href="http://mail.myspace.com/index.cfm?fuseaction=mail.message&amp;friendID=<?=$ms?>"><img
 src="http://i.myspace.com/site/images/sendMailIcon.gif"></a><a
 href="http://mail.myspace.com/index.cfm?fuseaction=mail.forward&amp;friendID=<?=$ms?>&amp;f=forwardprofile"><img
 src="http://i.myspace.com/site/images/forwardMailIcon.gif"></a><br>
<a
 href="http://www.myspace.com/index.cfm?fuseaction=invite.addfriend_verify&friendID=<?=$ms?>"><img
 src="http://i.myspace.com/site/images/addFriendIcon.gif"></a><a
 href="http://www.myspace.com/index.cfm?fuseaction=user.addToFavorite&amp;friendID=<?=$ms?>&amp;public=0"><img
 src="http://i.myspace.com/site/images/addFavoritesIcon.gif"></a><br>
<a
 href="http://groups.myspace.com/index.cfm?fuseaction=groups.addtogroup&amp;friendID=<?=$ms?>"><img
 src="http://i.myspace.com/site/images/icon_add_to_group.gif"></a><font size="1"> <br><a href="http://www.myspaceoutfit.com/">Created Using MySpace Contact Script V. 2.0.1</a></font>
<br><form name="ms">
<input onclick="copyit('ms.script')" type="button" value="Press to Copy" name="cpy"><br>
<textarea name="script" cols="50" rows="10">
<a href="<?=$url?>"><img
 src="http://viewmorepics.myspace.com/images/banner_130x55_03.gif"></a><br>
</div>
<a
 href="http://mail.myspace.com/index.cfm?fuseaction=mail.message&amp;friendID=<?=$ms?>"><img
 src="http://i.myspace.com/site/images/sendMailIcon.gif"></a><a
 href="http://mail.myspace.com/index.cfm?fuseaction=mail.forward&amp;friendID=<?=$ms?>&amp;f=forwardprofile"><img
 src="http://i.myspace.com/site/images/forwardMailIcon.gif"></a><br>
<a
 href="http://www.myspace.com/index.cfm?fuseaction=invite.addfriend_verify&friendID=<?=$ms?>"><img
 src="http://i.myspace.com/site/images/addFriendIcon.gif"></a><a
 href="http://www.myspace.com/index.cfm?fuseaction=user.addToFavorite&amp;friendID=<?=$ms?>&amp;public=0"><img
 src="http://i.myspace.com/site/images/addFavoritesIcon.gif"></a><br>
<a
 href="http://groups.myspace.com/index.cfm?fuseaction=groups.addtogroup&amp;friendID=<?=$ms?>"><img
 src="http://i.myspace.com/site/images/icon_add_to_group.gif"></a><font size="1"> <br><a href="http://www.myspaceoutfit.com/">Created Using MySpace Contact Script V. 2.0.1</a></font>
</textarea>
<? include "footer.php" ?>







