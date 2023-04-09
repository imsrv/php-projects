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

<HTML><HEAD>
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
<title></title></HEAD>

<body topmargin=0 bottommargin=0 marginheight=0 marginwidth=0 leftmargin=0 rightmargin=0 link=0000ff vlink=ff0000 bgcolor=$chatroomthemecolor text=000000>

<table  bgcolor=$chatroomthemecolor cellpadding=0 cellspacing=0 width=100% height=60 border=0><tr>
<td><center><font size=1 face=verdana color=$croomfcolormain>Powered by <a href=\"http://www.etown21.com/apersonalstouch\"><font color=$croomfcolormain>Apersonalstouch</font></a><br>Copyright &copy;2000,2001,2002<br>Adela Lewis(Edgewater Productions)</font></center></td>
</tr></table>

</BODY>
</HTML>\n";