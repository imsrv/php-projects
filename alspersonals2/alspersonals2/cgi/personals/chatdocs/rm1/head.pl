#!/usr/bin/perl -w

################################################################################
# Copyright 2001              
# Adela Lewis                 
# All Rights Reserved         
################################################################################

use CGI::Carp qw(fatalsToBrowser);

########################################################################################################################


require "../../configdat.lib";
require "../../variables.lib";



print "Content-type:text/html\n\n";
print "

<html><head>
<style>   
BODY { 	    
scrollbar-face-color: $chatscrollbarfacecolor;  	    
scrollbar-shadow-color: $chatscrollbarshadowcolor; 	    
scrollbar-highlight-color: $chatscrollbarhighlightcolor;  	    
scrollbar-3dlight-color: $chatscrollbar3dlightcolor; 	    
scrollbar-darkshadow-color: $chatscrolldarkshadowcolor;  	    
scrollbar-track-color: $chatscrollbartrackcolor; 	    
scrollbar-arrow-color: $chatscrollbararrowcolor; 	    
}   
</style>

<link rel=stylesheet type=text/css href=$personalsurl/styles.css>
<body topmargin=0 bottommargin=0 marginheight=0 marginwidth=0 leftmargin=0 rightmargin=0 link=0000ff vlink=ff0000 bgcolor=ffffff text=000000>

<form method=\"post\" action=\"$cgiurl/personalschat.pl\">
<table cellpadding=1 cellspacing=1 width=100% bgcolor=$chatroomthemecolor border=1 bordercolordark=$crbordercolordark bordercolorlight=$crbordercolorlight><tr>
<td bgcolor=$chatroomthemecolor width=30% valign=\"top\">
<table width=100% cellpadding=2 cellspacing=2 border=1 bordercolordark==$crbordercolordark bordercolorlight==$crbordercolorlight><tr>
<td bgcolor=$chatroomthemecolor><center>
<font size=2 color=$croomfcolormain face=geneva,verdana,arial><b>Select a chat personality</b></font></center></td></tr><tr>
<td><table width=100% cellpadding=2 cellspacing=2 bgcolor=ffffff border=1 bordercolordark=purple bordercolorlight=$chatroomthemecolor><tr>
<td><center><img src=\"$chatpersonalitiesurl/girl1.jpg\" border=0><br><input type=radio name=chperson value=\"girl1.jpg\"></center></td>
<td><center><img src=\"$chatpersonalitiesurl/guy1.jpg\" border=0><br><input type=radio name=chperson value=\"guy1.jpg\"></center></td>
<td><center><img src=\"$chatpersonalitiesurl/girl3.jpg\" border=0><br><input type=radio name=chperson value=\"girl3.jpg\"></center></td>
<td><center><img src=\"$chatpersonalitiesurl/guy2.jpg\" border=0><br><input type=radio name=chperson value=\"guy2.jpg\"></center></td>
<td><center><img src=\"$chatpersonalitiesurl/guy3.jpg\" border=0><br><input type=radio name=chperson value=\"guy3.jpg\"></center></td>
<td><center><img src=\"$chatpersonalitiesurl/girl4.jpg\" border=0><br><input type=radio name=chperson value=\"girl4.jpg\"></center></td>
</tr><tr>
<td><center><img src=\"$chatpersonalitiesurl/girl5.jpg\" border=0><br><input type=radio name=chperson value=\"girl5.jpg\"></center></td>
<td><center><img src=\"$chatpersonalitiesurl/girl2.jpg\" border=0><br><input type=radio name=chperson value=\"girl2.jpg\"></center></td>
<td><center><img src=\"$chatpersonalitiesurl/guy4.jpg\" border=0><br><input type=radio name=chperson value=\"guy4.jpg\"></center></td>
<td><center><img src=\"$chatpersonalitiesurl/girl6.jpg\" border=0><br><input type=radio name=chperson value=\"girl6.jpg\"></center></td>
<td><center><img src=\"$chatpersonalitiesurl/girl7.jpg\" border=0><br><input type=radio name=chperson value=\"girl7.jpg\"></center></td>
<td><center><img src=\"$chatpersonalitiesurl/girl8.jpg\" border=0><br><input type=radio name=chperson value=\"girl8.jpg\"></center></td>
</tr></table></td></tr></table></td>
<td width=30% bgcolor=$chatroomthemecolor valign=\"top\">
<table width=100% cellpadding=2 cellspacing=2 border=1 bordercolordark==$crbordercolordark bordercolorlight=$crbordercolorlight><tr>
<td bgcolor=$chatroomthemecolor><center>
<font size=2 color=$croomfcolormain face=geneva,verdana,arial><b>Select a chat font color</b></font></center></td></tr><tr>
<td><table width=100% height=124 bgcolor=ffffff cellpadding=2 cellspacing=2 border=0 bordercolordark=$crbordercolordark bordercolorlight=$crbordercolorlight><tr>
<td><center><font color=red size=2 face=verdana>RED</font><br><input type=radio name=chatfontcolor value=\"ff0000\"></center></td>
<td><center><font color=navy size=2 face=verdana>NAVY</font><br><input type=radio name=chatfontcolor value=\"000080\"></center></td>
<td><center><font color=008000 size=2 face=verdana>GREEN</font><br><input type=radio name=chatfontcolor value=\"008000\"></center></td></tr><tr>
<td><center><font color=0000FF size=2 face=verdana>BLUE</font><br><input type=radio name=chatfontcolor value=\"0000FF\"></center></td>
<td><center><font color=FF6600 size=2 face=verdana>ORANGE</font><br><input type=radio name=chatfontcolor value=\"ff6600\"></center></td>
<td><center><font color=800080 size=2 face=verdana>PURPLE</font><br><input type=radio name=chatfontcolor value=\"800080\"></center></td>
</tr></table></td></tr></table></td>

<td width=40% bgcolor=$chatroomthemecolor valign=\"top\">

<table bgcolor=$chatroomthemecolor cellpadding=2 cellspacing=2 width=100% border=0 bordercolordark=$crbordercolordark bordercolorlight=$crbordercolorlight><tr>
<td><table bgcolor=#ffffff width=100% height=120 cellpadding=0 cellspacing=0><tr>
<td width=5%>&nbsp;</td><td width=90%><center>&nbsp;</b></font></center></td><td width=5%>&nbsp;</td></tr><tr>
<td width=5%>&nbsp;</td>
<td width=90%><table width=100%><tr><td>
<font size=1 face=verdana>Username </font></td><td>
<input type=\"text\" name=\"username\" value=\"Guest\" size=20 class=\"box\"></td></tr>

<tr><td><font size=1 face=verdana>Logon Greeting</font></td><td>
<input type=\"text\" name=\"message\" Value=\"Hello everybody!\" size=20 class=\"box\"><br>
</td></tr></table></td>
<td width=5%>&nbsp;</td></tr><tr>

<td width=5%>&nbsp;</td><td width=90% align=\"right\"><input type=\"hidden\" name=\"chatlocale\" value=\"rm1\">
<input type=\"submit\" name=\"login\" value=\"Send Message\" class=\"button\"><br><br></TD>
<td width=5%>&nbsp;</td>

</tr></table></blockquote>

</td></tr></table></td></tr></table>
</form>
</body></html>\n";