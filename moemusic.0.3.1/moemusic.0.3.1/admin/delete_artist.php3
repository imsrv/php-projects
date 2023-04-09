<?
include moe_conf;

// this will delete an artist and all of there songs from 
// moe music. I'm going to have to add some safe guards to
// this part of the program as its very powerful

print "<HTML><HEAD>";
print "<META HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=admin.php3\">";
print "</HEAD><BODY BGCOLOR=\"#FFFFFF\">";

// connect to the database
$connection = mysql_connect($server_addr,$db_user_name,$db_password);

// need to remove all of the songs first

$dele_song_query = "delete from song where a_id = $art_id";
$dele_song_result = mysql_db_query($db_name,$dele_song_query,$connection);

if ($dele_song_result == false):
	print "There was a problem deleting the songs";
	die;
else:
	print "Songs successfully deleted<BR>";
endif;

// Now delete the artists id

$dele_art_query = "delete from artist where a_id = $art_id";
$dele_art_result = mysql_db_query($db_name,$dele_art_query,$connection);

if ($dele_art_result == false):
	print "There was a problem deleting the artist";
	die;
else:
	print "The artist was removed from moe music<BR>";
endif;

print "</BODY></HTML>";

?>
