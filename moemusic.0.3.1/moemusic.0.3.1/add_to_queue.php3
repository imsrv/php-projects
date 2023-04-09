<?
include moe_conf;

print "<HTML><HEAD>";
print "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"1; URL=index.php3\">";
print "</HEAD><BODY BGCOLOR=\"#FFFFFF\">";
// Open a db connection
$connection = mysql_connect($server_addr,$db_user_name,$db_password);

$counter = 1;
$song_id = explode(",",$song_list);
$count = count($song_id);

//for ($index=0;$index< count($song_id);$index++){
//print ("$index : $song_id[$index] <BR>\n");
//}




while ($counter < $count):

$ins_query = "INSERT INTO queue VALUES(NULL,$song_id[$counter])";

$ins_query_result = mysql_db_query($db_name,$ins_query,$connection);

if ($ins_query_result == 0):
	print "There is a problem with inserting into the queue";
	die;
endif;

$counter++;
endwhile;

print "The songs where entered into the queue";
print "</BODY></HTML>";
?>
