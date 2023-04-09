<?
include moe_conf;

print "<HTML><HEAD></HEAD><BODY BGCOLOR=\"#FFFFFF\">";


// This script spits out a list of artists with a radio button next to
// them to allow a person to see all of the songs by 1 artist


// connect to the database
$connection = mysql_connect($server_addr,$db_user_name,$db_password);


$grab_id_query = "SELECT a_name FROM artist";
$grab_id_result = mysql_db_query($db_name,$grab_id_query,$connection);

print "<h3> Select an Artist to see songs by </h3>";

print "<FORM method=\"POST\" action=\"process_find_artist.php3\">";

while ($row = mysql_fetch_row($grab_id_result))
{
	print "<INPUT TYPE=\"radio\" name=\"art_name\" value=\"$row[0]\">";
	print "$row[0]<BR>";



}

print "<INPUT TYPE=\"reset\"><INPUT TYPE=\"submit\">";
print "</FORM>";


print "</BODY></HTML>";
?>
