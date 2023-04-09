<?php

# NOTE: It is very important for security reasons, to place this file out of 
# reach of any browser if at all possible.
# if you are not able to place this file out of reach of browsers,
# leave it in the admin directory, and then password protect the admin directory

/*** SET VARIABLES HERE *****/ 
$dbhost = "my.sqlhost.com"; //Insert your database host
$dbname = "calogic"; //Insert your database name
$dbuser = "calogic"; //Insert your database username
$dbpass = "mypassword"; //Insert your database password

/***************************************************************
** $tabpre
** NOTE: this is the prefix for all tables created  
***************************************************************/    
/*** SET VARIABLE HERE *****/ 
$tabpre = "clc"; //Insert your table prefix here, SHOULD ONLY BE LETTERS
/***************************************************************
** $idxfile
** NOTE: set this to the name of the starting file name  
***************************************************************/    
/*** SET VARIABLE HERE *****/ 
$idxfile = "index.php";
?>