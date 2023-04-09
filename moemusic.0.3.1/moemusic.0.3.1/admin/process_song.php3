<?
include moe_conf;

print "<HTML><HEAD>";
print "<META HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=admin.php3\">";
print "</HEAD><BODY BGCOLOR=\"#FFFFFF\">";

// Open a connection to the Database Server
$connection = mysql_connect($server_addr,$db_user_name,$db_password);

// Some simple checks on the input to ensure validity
$chk_query = "SELECT a_id FROM artist WHERE a_id = $art_id";
$check_result = mysql_db_query($db_name,$chk_query,$connection);
$check_result = mysql_fetch_row($check_result);

if ($check_result != $art_id):
	print "Artist ID isn't listed please Fix";
	die;
endif;

$check_file_exists = file_exists($filename);

if ($check_file_exists == false):
	print "The file $filename doesn't exist check filename";
	print " and try again";
	die;
endif;

// check to see if the song is in the database
// This check needs to be better as it ignores whether
// the song could be performed by someone else
// must add that check

$chk_query = "SELECT s_name FROM song WHERE s_name = \"$songname\"";
$check_result = mysql_db_query($db_name,$chk_query,$connection);
$check_result = mysql_fetch_array($check_result);

if ($check_result[s_name] == $songname):
	print "$songname by $artist is already in the database";
	die;
endif;

// If all is good then do the insert

$ins_query = "INSERT INTO song VALUES(\"$songname\",NULL,$art_id,\"$filename\")";

$ins_result = mysql_db_query($db_name,$ins_query,$connection);


if ($ins_result == false):
	print "There was a problem with the insert";
	die;
endif;

print "The song $songname was added to the database";

print "</BODY></HTML>";

?>
