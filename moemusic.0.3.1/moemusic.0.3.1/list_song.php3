<?
include moe_conf;

print "<HTML><HEAD><TITLE>List of Known Artist's</TITLE></HEAD><BODY BGCOLOR=\"#FFFFFF\">";

// open a connection to moetmusic db
$connection = mysql_connect($server_addr,$db_user_name,$db_password);

// Grab all of the artist names and id's
$grab_id_query = "SELECT * FROM artist";
$grab_id_result = mysql_db_query($db_name,$grab_id_query,$connection);


// Then output each artist name, all of there songs and then the next
// artist, there songs etc

print "<FORM method=\"POST\" action=\"add_to_queue.php3\">";

while ($row = mysql_fetch_row($grab_id_result))
{
// print the name of the artist
	print "<H3>Songs by $row[0]</H3>";

	// need to grab the songs in the loop
	$song_name_query = "SELECT s_name,s_id FROM song WHERE a_id = $row[1]"; 	
	$song_name_result = mysql_db_query($db_name,$song_name_query,$connection);

	
	while($song_row = mysql_fetch_row($song_name_result)):
	    	print "<INPUT TYPE=\"checkbox\" NAME=\"song_id[]\"
VALUE=\"$song_row[1]\">";
        	print "$song_row[0]<BR>";

	
	endwhile;
	


}

print "<INPUT TYPE=\"reset\"><INPUT TYPE=\"submit\">";
print "</FORM>";

print "</BODY></HTML>";
?>
