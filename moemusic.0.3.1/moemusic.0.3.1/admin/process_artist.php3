<?
include moe_conf;

print "<HTML><HEAD>";
print "<META HTTP_EQUIV=\"refresh\" CONTENT=\"1; URL=admin.php3\">";
print "</HEAD><BODY BGCOLOR=\"#FFFFFF\">";
// Open the connection to the Database Server
$connection = mysql_connect($server_addr,$db_user_name,$db_password);

/* 
Check if the Artist is alrady present

Need to find  a way to look for close matches etc
*/
$chk_query = "SELECT a_name FROM artist WHERE a_name like  \"$artist\"";
$check_result = mysql_db_query($db_name,$chk_query,$connection);
$check_result = mysql_fetch_array($check_result);

if ($check_result[a_name]  == $artist):
	print "$artist is already in the Database";
	die;	
endif;

// Insert the Artist as they aren't there 

$ins_query = "INSERT INTO artist VALUES(\"$artist\",NULL)";

$ins_result = mysql_db_query($db_name,$ins_query,$connection);

if ($ins_result == false):
	print "There was a problem with the insert";
	die;
endif;

print "The artist $artist was added to the database";

print "</BODY></HTML>";
?>
