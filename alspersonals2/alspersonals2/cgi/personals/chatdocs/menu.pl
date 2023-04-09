#!/usr/bin/perl -w

################################################################################
# Copyright 2001              
# Adela Lewis                 
# All Rights Reserved         
################################################################################

use CGI::Carp qw(fatalsToBrowser);

########################################################################################################################


require "../configdat.lib";


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

<link rel=stylesheet type=text/css href=$personalsurl/includes/styles.css>
<body topmargin=0 bottommargin=0 marginheight=0 marginwidth=0 leftmargin=0 rightmargin=0 link=0000ff vlink=ff0000 bgcolor=$chatroomthemecolor text=000000>
<table width=100% cellpadding=2 cellspacing=2 border=0><tr>
<td width=30%><center><table width=80%><tr>
<td bgcolor=$chatmenutdcolor><a href=\"$cgiurl/chatdocs/rm2/index.pl\" target=\"_blank\"><font size=1 color=$croomfcolormain face=verdana>Woman to Woman Chat</font></a></td></tr><tr>
<td bgcolor=$chatmenutdcolor><a href=\"$cgiurl/chatdocs/rm3/index.pl\" target=\"_blank\"><font size=1 color=$croomfcolormain face=verdana>Man to Man Chat</font></a></td></tr><tr>
<td bgcolor=$chatmenutdcolor><a href=\"$cgiurl/chatdocs/rm1/index.pl\" target=\"_blank\"><font size=1 color=$croomfcolormain face=verdana>Heterosexual Chat</font></a></td></tr>
</table></center></td>
<td>&nbsp;</td></tr></table>
</body></html>\n";