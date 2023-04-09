 #!/usr/bin/perl
use CGi qw(:cgi);
print "Content-type: text/html\n\n";

if (param('whattodo') eq 'doitnow') { &doitnow; } 
else { &default; }

sub default {
	print "<html><body bgcolor=\"#000000\" text=\"#ffffff\"><br>Web Control Panel<br><br> \n";
	print "<form method=POST><input=hidden name=whattodo value=doitnow> \n";
	print "<table bgcolor=blue><tr><td> \n";
	print "<table> \n";
	print "<tr><td>Enter a Directory name:</td><td> <input type=text name=dir></td></tr> \n";
	print "<tr><td>Enter your Sites Name :</td><td> <input type=text name=sitename></td></tr> \n";
	print "<tr><td colspan=2><center><input type=submit value=\"Create This site!\"></td></tr> \n";
	print "</table> \n";
	print "<br><br><center><hr width=\"75%\"><br> \n";
	print "<br></body></html> \n";
}

sub doitnow {
system("sitegen.pl", param('dir'), param('sitename'));
	print "Done! Check your email.\n";
}
