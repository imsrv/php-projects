<?
/***************************************************************************
 *                         AutoHits  PRO                            *
 *                            -------------------
 *    Version          : 2.1                                                  *
 *   Released        : 04.22.2003                                     *
 *   copyright            : (C) 2003 SupaTools.com                           *
 *   email                : info@supatools.com                             *
 *   website              : www.supatools.com                 *
 *   custom work     :http://www.gofreelancers.com      *
 *   support             :http://support.supatools.com        *
 *                                                                         *
 *                                                                         *
 *                                                                         *
 ***************************************************************************/

require_once("../config_real_inc.php");

// do not edit below

function authenticate() {
    global $err;
    header( "WWW-Authenticate: Basic realm=\"Test Authentication System\"");
    header( "HTTP/1.0 401 Unauthorized");
    die($err[1]);
}


if(!MYSQL_CONNECT($hostnm,$usernm,$pwd)){
	die($err[2]);
}
if (!mysql_select_db("$dbName")){
	die($err[2]);
}
//$query = "select * from pass where login=\"".$PHP_AUTH_USER."\" and pass=\"".(crypt($PHP_AUTH_PW,2))."\"";
$query = "select * from pass where login=\"".$PHP_AUTH_USER."\" and pass=\"".(($PHP_AUTH_PW))."\"";
$result = MYSQL_QUERY($query);

//if((mysql_num_rows($result)!=1)or($PHP_AUTH_USER=="")or($PHP_AUTH_PW=="")){
//	authenticate();
//}
@mysql_free_result($result);

$num_en=10;

$t_language= "language";
$t_user= "user";
$t_site= "site";
$t_clear= "clear";
$t_cat= "cat";
$t_idu_idc= "idu_idc";
$t_idm_idc= "idm_idc";
$t_tmp_mail= "tmp_mail";

$num_rows=10;

$query = "select * from ".$t_clear;      
$result = MYSQL_QUERY($query);
if((mktime(0,0,0,date("m"),date("d"),date("Y"))!=mysql_result($result,0,"date"))and(date(w)==0)){
	require('weekstat.php');
}
@mysql_free_result($result);
