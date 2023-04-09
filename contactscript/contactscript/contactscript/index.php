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
********************************************************************************* //-->
<? include "header.php" ?><? if (is_file("install.php")) die("<b><br><br><br><center>Delete Install.php Before You Can View This Page!</center></b>"); ?>
<form style="color: rgb(255, 255, 255);"
 action="myspace.php" method="post">
  <p><strong>Myspace
Url:</strong><br>
  <input name="url" type="text"><br>
IE: http://www.myspace.com/mscontact
  </p>
  <p><strong>Myspace
ID:</strong><br>
  <input name="id" type="text"><br>
click view profile when you login<br>
in the address bar at the top you will see the url <br>
look for were it says friendID= and a number the
number is your ID
IE:
http://www.myspace.com/index.cfm?fuseaction=user.viewProfile&amp;<b>friendID=18904693</b>&amp;Mytoken=20050617185007
  <br>
The ID is 18904693 in this example
  </p>
  <p><input
 value="Get Myspace Code" type="submit"></p>
</form>
<span style="color: rgb(255, 255, 255);"></span>
<table style="text-align: left; width: 100%;"
 border="0" cellpadding="0" cellspacing="0">
  <tbody>
      
      </tbody>
</table>
<span style="color: rgb(255, 255, 255);"></span><!--/
myspacecontactscript.tk // BY: Mark Beard
// markbeardwebdesign@gmail.com
//--><? include "footer.php" ?>
</body>
</html>