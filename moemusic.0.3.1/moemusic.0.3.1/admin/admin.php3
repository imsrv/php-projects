<?
include moe_conf;

print "<HTML><HEAD><TITLE>Moe Music Admin Menu</TITLE></HEAD>";
print "<BODY BGCOLOR=\"#FFFFFF\">";

/*
The script will contain the basics of the moet music admin page
Need to add some sort of basic password to this page
*/

print "<CENTER><H1>Moe Music Admin</H1></CENTER>";

print "<TABLE><TR><TD>";

print "<A HREF=\"kill.php3\">Click Here</A> to cancel the current song<BR>";

print "<A HREF=\"../index.php3\">Click Here</A> to return to the main
menu<BR>";

print "<A HREF=\"clear_queue.php3\">Click Here</A> to clear song queue";

print "<H3>Copy a file from the upload directory</H3>";
print "<TABLE>";
print "<FORM Action=\"process_uploaded_insert.php3\" method=\"POST\">";
print "<TR><TD>Song Name :</TD><TD><INPUT Type=\"text\" Name=\"songname\" Size=15></TD></TR>";
print "<TR><TD>Artist Id :</TD><TD><INPUT Type=\"text\" Name=\"art_id\" Size=3></TD></TR>";
print "<TR><TD>File Name :</TD><TD><INPUT Type-\"text\" Name=\"filename\" Size=15></TD</TR>";
print "<TR><TD><INPUT Type=\"reset\"></TD><TD><INPUT Type=\"Submit\"></TD></TR>";
print "</FORM>";
print "</TABLE>";

print "<H3>Index an MP3 on the Server</H3>";
print "<TABLE>";
print "<FORM action=\"process_song.php3\" method=\"POST\">";
print "<TR><TD>Song Name :</TD><TD><INPUT Type=\"text\" Name=\"songname\" Size=15></TD></TR>";
print "<TR><TD>Artist Id :</TD><TD><INPUT Type=\"text\" Name=\"art_id\" Size=3></TD></TR>";
print "<TR><TD>File Name :</TD><TD><INPUT Type=\"text\" Name=\"filename\" Size= 15>";
print " <B>NB</B>: Must be an absoulte path</TD></TR>";
print "<TR><TD><INPUT Type=\"reset\"></TD><TD><Input Type=\"Submit\"></TD></TR>";
print "</FORM>";
print "</TABLE>";


print "<H3>Insert an Artist into the DataBase</H3>";
print "<TABLE>";
print "<FORM Method =\"POST\" Action=\"process_artist.php3\">";
print "<TR><TD>Artist Name : </TD><TD><INPUT Type=\"text\" Name=\"artist\" Size=15></TD></TR>";
print "<TR><TD><INPUT Type =\"reset\"></TD><TD><INPUT Type=\"submit\"></TD></TR>";
print "</FORM>";
print "</TABLE>";

print "<H3>Delete an Artist from the Database</H3>";
print "<TABLE>";
print "<FORM Method=\"POST\" Action=\"delete_artist.php3\">";
print "<TR><TD>Artist ID : </TD><TD><INPUT TYPE=\"text\" Name=\"art_id\" Size=3></TD></TR>";
print "<TR><TD><INPUT Type=\"reset\"></TD><TD><INPUT type=\"submit\"></TD></TR>";
print "</FORM>";
print "</TABLE>";

print "<BR>";

print "</TD><TD>";

// Grab all of the artist names and id's

include artist_id_list;

print "</TD></TR></TABLE>";
print "</BODY></HTML>";
?>
