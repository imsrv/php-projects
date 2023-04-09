<?php

require("config.php3");

/* Try to connect to database */
	mysql_connect( "$dbhost", "$dbuser", "$dbpass") or 
		die ( "Unable to connect to database server...");

/* Select database */
	mysql_select_db( "$dbname" ) or 
		die ( "Unable to select database...");

/* Set Email address to proper address if there is no hostname 
   and it is not blank */

        if ( ( !(ereg("@",$email))) && ( $email != '' )){  
	$email=$email.$hostmask;
        }
?>
