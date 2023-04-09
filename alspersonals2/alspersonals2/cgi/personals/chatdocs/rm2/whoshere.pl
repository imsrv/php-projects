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
require "userspresent.lib";



print "Content-type:text/html\n\n";
print "

<html><head>


<META HTTP-EQUIV=Refresh CONTENT=1><META HTTP-EQUIV=Pragma CONTENT=no-cache>

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
<body topmargin=0 bottommargin=0 marginheight=0 marginwidth=0 leftmargin=0 rightmargin=0 link=0000ff vlink=ff0000 bgcolor=$chatroomthemecolor text=000000>


<table cellpadding=1 cellspacing=1 width=100% bgcolor=$chatroomthemecolor border=0><tr>
<td>
<center><table width=80% bgcolor=$chatroomthemecolor><tr><td>
<b><font size=2 face=verdana color=$croomfcolormain>
<center>Who's Here?</font><font color=$croomfcolormain size=1 face=verdana>($currentuserspresent) chatting</center></b></font><p>
<ul>

</ul>
<center>
</center>
</td></tr></table></center>
</td></tr></table>
</form>
</body></html>\n";


