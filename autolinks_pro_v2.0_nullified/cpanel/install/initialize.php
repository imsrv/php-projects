<?
/////////////////////////////////////////////////////////////
// Program Name         : Autolinks Professional            
// Program Version      : 2.0                               
// Program Author       : ScriptsCenter                     
// Supplied by          : CyKuH [WTN] , Stive [WTN]         
// Nullified by         : CyKuH [WTN]                       
// Distribution         : via WebForum and Forums File Dumps
//                   (c) WTN Team `2002
/////////////////////////////////////////////////////////////

  include( "../variables.php" );
  include( "functions.php" );

  $dbcnx = mysql_connect( $mysql_host, $mysql_user, $mysql_pass )
    or exit( "Error! Can't connect to MySQL server. Please check the variables.php files" );

  mysql_select_db( $mysql_db )
    or exit( "Error! Can't find '$mysql_db' database. Please make sure it exists" );

?>