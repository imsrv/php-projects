<?
include moe_conf;

print "<HTML><HEAD><TITLE>Find Artist</TITLE></HEAD><BODY BGCOLOR=\"#FFFFFF\">";
print "<H1>What is the name of the Artist You Seek ?</H1>";

print "<FORM Method=\"POST\" Action=\"process_find_artist.php3\">";
print "<BR>Artist's Name : <INPUT Type=\"text\" Name=\"art_name\" Size=15>";
print "<BR><INPUT Type=\"reset\"><INPUT Type=\"submit\">";

print "</BODY></HTML>";




?>
