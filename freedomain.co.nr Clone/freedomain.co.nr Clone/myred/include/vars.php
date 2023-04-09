<?php
##################################################
#### vars.php - some variables have to be set by admin        ####
##################################################
// hostname of the server
$mysql_host = 'localhost';

// mysql-username
$mysql_username = 'username';

// mysql-password
$mysql_passwd = 'password';

// the name of the database
$mysql_dbase = 'myred';

// table names which will be used to save the data (notice: no more advertiser tables will be needed as advertising management is no longer part of these scripts)
$redir_table = "redir";
$options_table = "options";
$domain_table = "tld";
$category_table = "categories";
$visitor_table = "visitor";

// You may change the following value
$dateformat = "d. M. Y H:i ";

// How many colums should we show in the member pages directory main page?
$col_counts = 3;

// How many links per page should we show in the member pages directory?
$perpage = 3;

// The table witdh of the member pages directory main page
$table_width = "80%";

// How many days do you want to track the members stats? The more you take, the bigger the database will grow.
// But remember, that members only get average stats, therefore the database would not grow forever,
// it just keeps the stats for the number of days you take, older ones get deleted automatically - quite confusing, isn't it? :-)
// Anyway, don't set it shorter than to 7 days.
$keepstats = 14;
?>