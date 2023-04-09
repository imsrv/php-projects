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
<FRAMESET COLS=\"150,\*\">

        <FRAME SRC=$cgiurl/chatdocs/rm3/whoshere.pl marginwidth=0 marginheight=0 scrolling=\"auto\" noresize frameborder=\"$chatroomborderyn\" border=$chatroombordersize bordercolor=$chatroombordercolor>
	<FRAME SRC=$personalsurl/chatdocs/rm3.html marginwidth=0 marginheight=0 scrolling=\"auto\" noresize frameborder=\"$chatroomborderyn\" border=$chatroombordersize bordercolor=$chatroombordercolor>
	
</FRAMESET>
<NOFRAMES>
<body>
</NOFRAMES>
</body>
</html>

\n";