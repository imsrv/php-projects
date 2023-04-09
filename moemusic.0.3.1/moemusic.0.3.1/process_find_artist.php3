<?
include moe_conf;

print "<HTML><HEAD>";

// print the javascript stuff


print "<script>";
print "function add_song(song_no){\n";
print "var tmp = document.get_song.song_list.value \n";
print "tmp = tmp + \",\" + song_no \n";
print "document.get_song.song_list.value = tmp \n";
print "}\n";

print "</script>\n";



print "</HEAD><BODY BGCOLOR=\"#FFFFFF\">";

// Open yet another db connection
$connection = mysql_connect($server_addr,$db_user_name,$db_password);

// Do the Search 
// This is a really budget search
// Need to find a better way of doing this

$art_name2 = "%" . $art_name . "%";

$artist_search_query ="SELECT * FROM artist WHERE a_name like \"$art_name2\" ";
$artist_search_result = mysql_db_query($db_name,$artist_search_query,$connection);

$rowcount = mysql_num_rows($artist_search_result);

if ($rowcount == 0):
	print "The Artist $art_name Wasn't Found<BR>";
	die;

elseif ($rowcount > 1):
	print "There Where Multiple Close Matches to your request";
	print "please try again";
	die;
endif;

// Now that we only have 1 artist as the possible match
// lets grab the songs and dump out the possible choices

$art_info = mysql_fetch_array($artist_search_result);
$art_id = $art_info[1];

//Grab all of the song names

$song_search_query="SELECT s_name,s_id FROM song WHERE a_id = $art_id group by s_name";
$song_search_result=mysql_db_query($db_name,$song_search_query,$connection);

// Now print out the list of songs with check boxes to select songs and
// add to the queue of the jukebox

$art_name2 = $art_name . "'s";

print "<H3> Select Songs From $art_name2 Repotoire</H3>\n"; 
print "<FORM Method=\"POST\" Action=\"add_to_queue.php3\" name=\"get_song\">\n";
print "<INPUT TYPE=\"hidden\" NAME=\"song_list\" VALUE=\"\">\n";

while ($row = mysql_fetch_row($song_search_result))
{
	print "<INPUT TYPE=\"checkbox\" NAME=\"song_value\" VALUE=\"$row[1]\"";
	print "onClick=\"add_song($row[1])\">";
	print "$row[0]<BR>\n";
}

print "<BR><INPUT Type=\"reset\"><INPUT Type=\"submit\">\n";

print "</BODY></HTML>";
?>
