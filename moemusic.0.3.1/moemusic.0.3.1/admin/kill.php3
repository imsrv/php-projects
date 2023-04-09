<?
include moe_conf;

// this will just stop the currently playing song 
// it needs a redirect to go back to the admin menu

print "<HTML><HEAD>";
print "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL=admin.php3\">";
print "</HEAD><BODY BGCOLOR=\"#FFFFFF\">";

exec("/usr/bin/killall $mp3player");

print "The current song has been terminated";
print "</BODY></HTML>";
?>
