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

require_once("config_real_inc.php");

// DO NOT EDIT ANYTHING BELOW
$num_en=10;

$t_language= "language";
$t_user= "user";
$t_site= "site";
$t_clear= "clear";
$t_cat= "cat";
$t_idu_idc= "idu_idc";
$t_idm_idc= "idm_idc";
$t_tmp_mail= "tmp_mail";

if(!MYSQL_CONNECT($hostnm,$usernm,$pwd)){
	die($err[2]);
}
if (!mysql_select_db($dbName)){
	die($err[2]);
}

$query = "select * from ".$t_clear;      
$result = MYSQL_QUERY($query);
if((mktime(0,0,0,date("m"),date("d"),date("Y"))!=mysql_result($result,0,"date"))and(date(w)==0)){
	unset($body,$subject,$row,$result);
	require('admin/error_inc.php');
	require('admin/weekstat.php');
	unset($body,$subject,$row,$result);
	require('error_inc.php');
}
@mysql_free_result($result);
