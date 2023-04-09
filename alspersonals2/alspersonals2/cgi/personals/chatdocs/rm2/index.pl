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
<html>
<head>

<link rel=stylesheet type=text/css href=$personalsurl/styles.css>


	<title>Personals</title>

</head>
<FRAMESET ROWS=\"115,\*,60,45\">

        <FRAME SRC=$cgiurl/chatdocs/rm2/head.pl marginwidth=0 marginheight=0 scrolling=\"auto\" noresize frameborder=\"$chatroomborderyn\" border=$chatroombordersize bordercolor=$chatroombordercolor>
	<FRAME SRC=$cgiurl/chatdocs/rm2/rm2.pl marginwidth=0 marginheight=0 scrolling=\"auto\" noresize frameborder=\"$chatroomborderyn\" border=$chatroombordersize bordercolor=$chatroombordercolor>
	<FRAME SRC=$cgiurl/chatdocs/menu.pl marginwidth=0 marginheight=0 scrolling=\"auto\" noresize frameborder=\"no\" border=0>
       	<FRAME SRC=$cgiurl/chatdocs/bottom.pl marginwidth=0 marginheight=0 scrolling=\"auto\" noresize frameborder=\"no\" border=0>
        
</FRAMESET>
<NOFRAMES>
<body>
</NOFRAMES>
</body>
</html>

\n";