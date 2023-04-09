<?php
//GamaSoftware GamaBlog v1.0.0
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

//Collect Cp Functions
require("./cpfunctions.php");

//perform sessions check.
if (!isset($usercookie) || !isset($passcookie)) {
	if (isset($loginusername) and isset($loginpassword)) {
		if ($username=$DB_site->query_first("SELECT value FROM blog_options WHERE name='username' And value='".addslashes(htmlspecialchars($loginusername))."'")) {
			if ($password=$DB_site->query_first("SELECT value FROM blog_options WHERE 	name='password' AND value='".addslashes(htmlspecialchars($loginpassword))."'")){
					$domain=$DB_site->query_first("SELECT value FROM blog_options WHERE name='domain'");
					$exptime=time()+60*60*24*3;
					setcookie("usercookie",$loginusername,$exptime,"/","$domain[value]");
					setcookie("passcookie",$loginpassword,$exptime,"/","$domain[value]");
					 header ("Location: index.php");
			}else{
					blogcphead();
					echo" Wrong Username or Password";
					blogtablehead("Please Log In","","Please Type in your username and password.");
					blogtextbox("Username","Your blog username","loginusername","","40","100");
					blogpassword("Password","Your blog password","loginpassword","","40","100");
					blogtablefoot();
					blogcpfoot();
					exit;
			}
		}else{
					blogcphead();
					echo" Wrong Username or Password";
					blogtablehead("Please Log In","","Please Type in your username and password.");
					blogtextbox("Username","Your blog username","loginusername","","40","100");
					blogpassword("Password","Your blog password","loginpassword","","40","100");
					blogtablefoot();
					blogcpfoot();
					exit;
		}
	}else{
		blogcphead();
		blogtablehead("Please Log In","","Please Type in your username and password.");
		blogtextbox("Username","Your blog username","loginusername","","40","100");
		blogpassword("Password","Your blog password","loginpassword","","40","100");
		blogtablefoot();
		blogcpfoot();
		exit;
	}
}

if($action=="logout"){
	$domain=$DB_site->query_first("SELECT value FROM blog_options WHERE name='domain'");
	setcookie("usercookie","loggedout",time() - 3600,"/","$domain[value]");
	setcookie("passcookie","dsfdsafsfd",time() - 3600,"/","$domain[value]");
	blogcphead();
	echo "Successfully logged out.";
	blogtablehead("Please Log In","","Please Type in your username and password.");
	blogtextbox("Username","Your blog username","loginusername","","40","100");
	blogpassword("Password","Your blog password","loginpassword","","40","100");
	blogtablefoot();
	blogcpfoot();
	exit;
}

$userinfo=$DB_site->query_first("SELECT value FROM blog_options WHERE name='username'");
$passinfo=$DB_site->query_first("SELECT value FROM blog_options WHERE name='password'");
if($usercookie != $userinfo[value] || $passcookie != $passinfo[value]){
	blogcphead();
	blogtablehead("Please Log In","","Please Type in your username and password.");
	blogtextbox("Username","Your blog username","loginusername","","40","100");
	blogpassword("Password","Your blog password","loginpassword","","40","100");
	blogtablefoot();
	blogcpfoot();
	exit;
}
$userinfo="";
$passinfo="";
$usercookie="";
$passcookie="";

?>