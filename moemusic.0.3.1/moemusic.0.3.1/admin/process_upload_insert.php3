<?
include moe_conf;

print "<HTML><HEAD></HEAD><BODY BGCOLOR=\"#FFFFFF\">";

/*
This script will take files that have been uploaded into the database
and name them via there s_id number to avoid name clashes. 
*/

// Open a connection to the server
$connection = mysql_connect($server_addr,$db_user_name,$db_password);

$check_a_id_query = "SELECT a_id from artist where a_id = $art_id";
$check_a_id_result = mysql_db_query($db_name,$check_a_id_query$connection);

if ($check_a_id_result == 0):
	print "The Artist ID was not found";
	die;
endif;

// Insert the song into the database

$ins_query = "INSERT INTO song VALUES($song_name,NULL,$art_id,\"placehold\");
$ins_result = mysql_db_query($db_name,$ins_query,$connection);

if ($ins_result == false):
	print "There was an error adding the file";
	die;
endif;

// Now get the song id of the file and copy the file
// and then change placeholder to the real file name
$s_id = mysql_insert_id($ins_result);
$filename = $location . $s_id . "mp3";
$uploaded = $upload . $filename;

$cpresult=copy($uploaded,$filename);

if ($cpresult == 0):
	print "There was an error coping the file $uploaded_file_name";
	die;
endif;

// update the file name in teh database

$update_query = "UPDATE song set file_name=\"$file_name\" where s_id = $s_id";
$update_result = mysql_db_query($db_name,$update_query,$connection);

if ($update_result == 0):
	print "There was an error resetting the file name";
	die;
endif;

$del_result =unlink($uploaded_file);

if ($del_result == 0):
	print "Problem with deleting tmp file";
	die;
endif;


print "</BODY></HTML>";
?>
