<?php
/**
 * 
 * @file config.php
 */
 
/**
 * Database settings.
 * Leave the DB_TYPE variable untouched, only Mysql is supported ATM.
 */
$config['DB_HOST'] = 'localhost';
$config['DB_TYPE'] = 'mysql';
$config['DB_USER'] = '';
$config['DB_PASS'] = '';
$config['DB_NAME'] = '';

/**
 * Don't touch this unless you know what you are doing. In case you are, add a ':' at the beginning.
 * /tmp/mysql.sock would become :/tmp/mysql.sock
 */
$config['DB_SOCK'] = '';
 
/**
 * Administrator's username and password
 */
$config['ADM_UNAME'] = 'CHANGE_ME';
$config['ADM_PASS'] = 'CHANGE_ME';

/**
 * Main page selection. This will be improved in future versions.
 */
$config['MAIN'] = 'Grid';
?>
