#!/usr/local/bin/perl

########################################################################
# PROGRAM NAME : YellowMaker
# COPYRIGHT: YellowMaker.com
# E-MAIL ADDRESS: webmaster@yellowmaker.com
# WEBSITE: http://www.yellowmaker.com/
########################################################################
# printenv.pl
########################################################################

print "Content-type: text/html\n\n<br><br>";
print "<b>Environment Variable Report</b>:";
print "<br>";
print "<br>";
print "<br>";
print "AUTH_TYPE=$ENV{'AUTH_TYPE'}<br>";
print "CONTENT_LENGTH=$ENV{'CONTENT_LENGTH'}<br>";
print "CONTENT_TYPE=$ENV{'CONTENT_TYPE'}<br>";
print "DOCUMENT_ROOT=$ENV{'DOCUMENT_ROOT'}<br>";
print "GATEWAY_INTERFACE=$ENV{'GATEWAY_INTERFACE'}<br>";
print "HTTP_ACCEPT=$ENV{'HTTP_ACCEPT'}<br>";
print "HTTP_ACCEPT_ENCODING=$ENV{'HTTP_ACCEPT_ENCODING'}<br>";
print "HTTP_ACCEPT_LANGUAGE=$ENV{'HTTP_ACCEPT_LANGUAGE'}<br>";
print "HTTP_CONNECTION=$ENV{'HTTP_CONNECTION'}<br>";
print "HTTP_HOST=$ENV{'HTTP_HOST'}<br>";
print "HTTP_USER_AGENT=$ENV{'HTTP_USER_AGENT'}<br>";
print "PATH=$ENV{'PATH'}<br>";
print "PATH_INFO=$ENV{'PATH_INFO'}<br>";
print "PATH_TRANSLATED=$ENV{'PATH_TRANSLATED'}<br>";
print "QUERY_STRING=$ENV{'QUERY_STRING'}<br>";
print "REMOTE_ADDR=$ENV{'REMOTE_ADDR'}<br>";
print "REMOTE_HOST=$ENV{'REMOTE_HOST'}<br>";
print "REMOTE_IDENT=$ENV{'REMOTE_IDENT'}<br>";
print "REMOTE_PORT=$ENV{'REMOTE_PORT'}<br>";
print "REMOTE_USER=$ENV{'REMOTE_USER'}<br>";
print "REQUEST_METHOD=$ENV{'REQUEST_METHOD'}<br>";
print "REQUEST_URI=$ENV{'REQUEST_URI'}<br>";
print "SCRIPT_FILENAME=$ENV{'SCRIPT_FILENAME'}<br>";
print "SCRIPT_NAME=$ENV{'SCRIPT_NAME'}<br>";
print "SERVER_ADDR=$ENV{'SERVER_ADDR'}<br>";
print "SERVER_ADMIN=$ENV{'SERVER_ADMIN'}<br>";
print "SERVER_NAME=$ENV{'SERVER_NAME'}<br>";
print "SERVER_PORT=$ENV{'SERVER_PORT'}<br>";
print "SERVER_PROTOCOL=$ENV{'SERVER_PROTOCOL'}<br>";
print "SERVER_SIGNATURE=$ENV{'SERVER_SIGNATURE'}<br>";
print "SERVER_SOFTWARE=$ENV{'SERVER_SOFTWARE'}<br>";
print "<br>";
print "<br>";
print "<br>";
exit;
