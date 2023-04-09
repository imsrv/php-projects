<?php
/*********************************************************
			This Free Script was downloaded at			
			Free-php-Scripts.net (HelpPHP.net)			
	This script is produced under the LGPL license		
		Which is included with your download.			
	Not like you are going to read it, but it mostly	
	States that you are free to do whatever you want	
				With this script!						
*********************************************************/
echo "Trying to includes configuration file (configure.php):<br />";

include_once("configure.php");

echo "Opening database file for reading (database.sql):<br />";
$sqlfile = fopen("database.sql",'r');

if($sqlfile){ echo "Sucess.<br />";}else{echo "Failed.<br />";exit();}

echo "Please wait while reading sql file (database.sql):<br />";

while($cont = fread($sqlfile,1024)){
	$sql_file_cont .= $cont;
}

echo "Done reading sql file (database.sql):<br />";

echo "Please wait while closing sql file (database.sql):<br />";
fclose($sqlfile);

echo "Please wait while inserting sql file into database:<br />";

$queries = explode(";",$sql_file_cont);

foreach($queries as $query){
	mysql_query($query);
}

echo "Database has been completely set-up, please procces with deleting sql file (database.sql).<br />";
echo "To login your contol panel, use the username/password located on configure.php (changable).<br />";
echo "Access your control panel by <a href=\"../index.php\">clicking here</a>.<br />";

?>
