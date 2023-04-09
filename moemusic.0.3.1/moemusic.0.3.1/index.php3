<?
include moe_conf;

print "<HTML><HEAD><TITLE>Moe Music Start Page</TITLE>";
print "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"60;URL=index.php3\">";
print "</HEAD>";
print "<BODY BGCOLOR=\"#FFFFFF\">";


// this file will contain a list of the currently running song
// as well as links to the different parts of the engine

// connect to the database
$connection = mysql_connect($server_addr,$db_user_name,$db_password);

// Look for the lock file to check if anything is actually being played

if (file_exists("/tmp/moet..LCK")):
	$get_q_number_query = "SELECT MIN(q_number) FROM queue";
	$get_q_number_result = mysql_db_query($db_name,$get_q_number_query,$connection);
	$q_number = mysql_fetch_array($get_q_number_result);
	$q_number = $q_number[0];

	$find_song_query = "SELECT s_name,a_name from queue,artist,song where artist.a_id = song.a_id and queue.s_id = song.s_id and q_number = $q_number";
	$find_song_result = mysql_db_query($db_name,$find_song_query,$connection);
	$current_track = mysql_fetch_array($find_song_result);
	$current_track = $current_track[s_name] . " by " . $current_track[a_name];

else:
	$current_track = "Nothing";
endif;

print "<CENTER><IMG SRC=\"images/moemusiclogo.jpg\"></CENTER>";


print "<TABLE><TR><TD>";

print "<BR><H3>Now Playing : $current_track</H3>";

// Find an artist by name or partial name

print "<H4>Search By Artist Name</H4>";
print "<FORM Method=\"POST\" Action=\"process_find_artist.php3\">";
print "Artist's Name :<INPUT Type=\"text\" Name=\"art_name\" Size=15>";
print "<BR><INPUT Type=\"reset\"><INPUT Type=\"submit\">";


print "<BR><BR>";
//print "<A HREF=\"list_song.php3\">Click Here</A> to see a list of all artists and songs";

print "<BR>";
print "<A HREF=\"list_artist_link.php3\">Click Here</A> to see all of the artists";

print "<BR>";
print "<A HREF=\"player.php3\">Click Here</A> to play songs then press stop on your browser";

print "<BR>";
print "<A HREF=\"admin/index.php3\">Click Here</A> to open the admin menu";
print "<BR>";


print "</TD><TD><CENTER>";


// select all of the songs except the first one from the queue

$queue_list_query = "SELECT q_number,a_name,s_name from queue,artist,song where q_number != $q_number and song.s_id = queue.s_id and song.a_id = artist.a_id order by q_number";
$queue_list_result = mysql_db_query($db_name,$queue_list_query,$connection);


// now loop through the result to see all of the songs to play

if (mysql_affected_rows($connection) >= 1)
{
print "<TABLE BORDER=1 CELLPADDING=3 >";
print "<TR><TD><B>Number</B></TD><TD><B>Artist</B></TD><TD><B>Song</B></TD></TR>";

while ($row = mysql_fetch_row($queue_list_result)):

	print "<TR><TD>$row[0]</TD>";
	print "<TD>$row[1]</TD>";
	print "<TD>$row[2]</TD></TR>";

endwhile;
}
print "</TABLE>";


print "</TD></CENTER></TABLE></BODY></HTML>";
?>
