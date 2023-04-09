<?
include moe_conf;

print "<HTML><HEAD>";
print "<META HTTP-EQUIV=\"refresh\" CONTENT=\"2; URL=index.php3\">";
print "</HEAD><BODY BGCOLOR=\"#FFFFFF\">";



// player will be run but forked off quickly into the background
// then will read the smallest song out of the queue
// delete it from the queue and then play it
// when it is done it will repeat until the queue is empty
// then it dies and waits for the queue to get songs in it again

// Open a connection ot the database
$connection = mysql_connect($server_addr,$db_user_name,$db_password);

// check for the exisitence of /tmp/moet..LCK, die if it does exist
// or else touch it to create it and start to play music

if (file_exists("/tmp/moet..LCK")):
	print "Already Playing";
	die;
else:
	touch("/tmp/moet..LCK");
endif;

// Now that where not playing we need to go into a play loop
// and go throught the  data base and play songs, and pul them out of the
// queue as we go.

while(1 < 2):

// get the first song in the queue
$get_q_number_query = "SELECT MIN(q_number) FROM queue";
$get_q_number_result = mysql_db_query($db_name,$get_q_number_query,$connection);
$q_number = mysql_fetch_array($get_q_number_result);
$q_number = $q_number[0];

// check if there are no songs left and if so die
// and remove lock file

if ($q_number == 0 ):
	unlink("/tmp/moet..LCK");
	die;
endif;


// get its s_id number
$get_song_query = "SELECT s_id FROM queue WHERE q_number = $q_number";
$get_song_result = mysql_db_query($db_name,$get_song_query,$connection);
$song_id = mysql_fetch_row($get_song_result);
$song_id = $song_id[0];

// Get the song filename from the song db
$get_filename_query = "SELECT file_name FROM song WHERE s_id = $song_id";
$get_filename_result =mysql_db_query($db_name,$get_filename_query,$connection);
$file_name = mysql_fetch_array($get_filename_result);
$file_name = $file_name[0];

// Now play the song and wait for the mp3 player to return

$playcommand = $mp3player . " " . $file_name ;

$played = exec($playcommand);

print "$played";
print "$q_number";
// pull the song from the queue
$remove_queue_query = "DELETE FROM queue WHERE q_number = $q_number";
$remove_queue_result= mysql_db_query($db_name,$remove_queue_query,$connection);

// if the song removal didn't work die
//if ($remove_queue_result == false):
$affected_rows = mysql_affected_rows($connection);

if ($affected_rows == 0):
      print "There was a problem removing a song";
      die;
endif; 

mysql_free_result($get_q_number_result);
mysql_free_result($get_song_result);
mysql_free_result($get_filename_result);

endwhile;

print "</BODY></HTML>";

?>
