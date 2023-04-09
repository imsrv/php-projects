<?
include moe_conf;

print "<HTML><HEAD>";
print "<META HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=admin.php3\">";
print "</HEAD><BODY BGCOLOR=\"#FFFFFF\">";

// Remove all of the songs from the queue except the current
// playing one

$connection = mysql_connect($server_addr,$db_user_name,$db_password);

// Check if the player is currently running and find the low song

if (file_exists("/tmp/moet..LCK")):
	$low_song_query = "SELECT min(q_number) FROM queue";
	$low_song_result = mysql_db_query($db_name,$low_song_query,$connection);
	$min_song = mysql_fetch_array($low_song_result);
	$min_song = $min_song[0];

else:
	$min_song = "0";

endif;

$del_song_query = "DELETE FROM queue WHERE q_number != $min_song";
$del_song_result = mysql_db_query($db_name,$del_song_query,$connection);

if ($del_song_result == false):
	print "There was a problem deleting the songs";
	die;

else:
	print "All songs canceled from the queue";

endif; 

print "</BODY></HTML>";

?>
