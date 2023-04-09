<?php
/* Nullified by GTT */
error_reporting(7);

//collect browser variables
@extract($HTTP_SERVER_VARS, EXTR_SKIP);
@extract($HTTP_COOKIE_VARS, EXTR_SKIP);
@extract($HTTP_POST_FILES, EXTR_SKIP);
@extract($HTTP_POST_VARS, EXTR_SKIP);
@extract($HTTP_GET_VARS, EXTR_SKIP);
@extract($HTTP_ENV_VARS, EXTR_SKIP);

//Obtain configuration files and database class
require("./config.php");
require("./db_mysql.php");

//Database init
$DB_site=new DB_Sql_vb;
$DB_site->appname="GamaBlog";
$DB_site->appshortname="blog";
$DB_site->database=$dbname;
$DB_site->server=$servername;
$DB_site->user=$dbusername;
$DB_site->password=$dbpassword;
$DB_site->connect();
$dbpassword="";
$DB_site->password="";

//call options variables
$massoptions=$DB_site->query("SELECT * FROM blog_options WHERE id > 2 ORDER BY id");
while($option=$DB_site->fetch_array($massoptions)){
	$option[value]=addslashes($option[value]);
    $option[value]=str_replace("\\'","'",$option[value]);
	eval("\$o$option[name] = \"".$option[value]."\";");
}

//Call All Bit Templates
$bittemplates=$DB_site->query("SELECT * FROM blog_templates WHERE loadorder < 0 ORDER BY loadorder");
while($bittemp=$DB_site->fetch_array($bittemplates)){
	$bittemp[template]=addslashes($bittemp[template]);
    $bittemp[template]=str_replace("\\'","'",$bittemp[template]);
	 $template[$bittemp[name]] = $bittemp[template];
}
//Php Addins go here
	//Entry Grabber script
		$entryz=$DB_site->query("SELECT * FROM blog_entries ORDER BY id DESC LIMIT 10");
		while($entryinfo=$DB_site->fetch_array($entryz)){
			  eval("\$entry .= \"".$template[entry_bit]."\";");
		}
		$entry = stripslashes($entry);
	//End of Entry Grabber
//End of Php Addins
//Mass Global Templation
$masstemplates=$DB_site->query("SELECT * FROM blog_templates WHERE loadorder > 0 ORDER BY loadorder");
while($template2=$DB_site->fetch_array($masstemplates)){
	$template2[template]=addslashes($template2[template]);
    $template2[template]=str_replace("\\'","'",$template2[template]);
	eval("\$$template2[name] = \"".$template2[template]."\";");
	\$$template2[name]=stripslashes(\$$template2[name]);
}
?>