<?php

########################
# PLEASE MODIFY BELOW: #
########################

//database host
$db_host = 'localhost';

//database username
$db_username = 'username';

//database password
$db_password = 'password';

//database name
$db_name = 'dbname';

###############################
#            STOP!            #
# DO NOT EDIT BELOW THIS LINE #
###############################

mysql_connect($db_host,$db_username,$db_password) or die(mysql_error());
mysql_select_db($db_name) or die(mysql_error());
?>