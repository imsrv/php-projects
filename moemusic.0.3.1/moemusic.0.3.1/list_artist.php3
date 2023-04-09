<?
include moe_conf;

print "<HTML><HEAD><TITLE>List of Known Artist's</TITLE></HEAD>";
print "<BODY BGCOLOR=\"#FFFFFF\">";

// open a connection to moetmusic db
$connection = mysql_connect($server_addr,$db_user_name,$db_password);

// Grab all of the artist names and id's
$grab_id_query = "SELECT * FROM artist";
$grab_id_result = mysql_db_query($db_name,$grab_id_query,$connection);

print "<H3>Insert an Artist into the DataBase</H3>";
print "<FORM Method =\"POST\" Action=\"process_artist.php3\">";
print "Artist Name : <INPUT Type=\"text\" Name=\"artist\" Size=15>";
print "<BR> <INPUT Type =\"reset\"><INPUT Type=\"submit\">";

print "<TABLE BORDER CELLSPACING=4 CELLPADDING=5>";
print "<TR><TD><B>Artist</B></TD><TD><B>Artist Id</B></TD></TR>";

while ($row = mysql_fetch_row($grab_id_result))
{
	print "<TR>";
	print "<TD>$row[0]</TD>";
	print "<TD>$row[1]</TD>";
	print "</TR>";
}

print "</TABLE>";

print "</BODY></HTML>";
?>
