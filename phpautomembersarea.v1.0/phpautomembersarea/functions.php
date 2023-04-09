<?
/**********************************************************
 *             phpAutoMembersArea                         *
 *           Author:  Seiretto.com                        *
 *    phpAutoMembersArea © Copyright 2003 Seiretto.com    *
 *              All rights reserved.                      *
 **********************************************************
 *        Launch Date:  Dec 2003                          *
 *                                                        *
 *     Version    Date              Comment               *
 *     1.0       15th Dec 2003      Original release      *
 *                                                        *
 *  NOTES:                                                *
 *        Requires:  PHP 4.2.3 (or greater)               *
 *                   and MySQL                            *
 **********************************************************/
$phpAutoMembersArea_version="1.0";
// ---------------------------------------------------------

$installed_config_file = "config.inc.php";

$thedomain = (isset($HTTP_HOST) ? $HTTP_HOST : $SERVER_NAME);
if (substr($thedomain,0,4)=="www.") $thedomain=substr($thedomain,4,strlen($thedomain));

function clean_input($string)
{
 $string = trim($string);
 $string = addslashes($string);
 return preg_replace("/[<>]/", '_', $string);
}

function db_connect()
{
 global $db_link;
 @$db_link = mysql_connect(DBHOST, DBUSER, DBPASS);
 if ($db_link) @mysql_select_db(DBNAME);
 return $db_link;
}

function db_close()
{
 global $db_link;
 if ($db_link) $result = mysql_close($db_link);
 return $result;
}

function is_email($email)
{
 return ((strrpos($email,"@")>0) and (strrpos($email,".")>0) and (strrpos($email,"\"")==false) and (strlen($email)>6));
}

function pama_mail($email,$thesubject,$themessage,$fromemail,$replyemail, $thedomain)
{
 // uncomment two lines below to test locally - localhost - DO NOT leave uncommented
 //if ($thedomain=="localhost") echo "<hr>would send email to: $email<hr>Subject: $thesubject<br>$themessage";
 //else
  mail("$email",
   "$thesubject",
   "$themessage",
   "From: $fromemail\nReply-To: $replyemail");
}

function random_password($pass_length)
{
 $new_pass = '';
 mt_srand ((double) microtime() * 1000000);
 while($pass_length > 0)
 {
  $new_char = mt_rand(48, 90);
  if($new_char > 57 && $new_char < 65) continue;
  $new_pass .= sprintf("%c",$new_char);
  $pass_length--;
 }
 return $new_pass;
}

function js_msg($msg)
{
 echo "<script language=\"JavaScript\"><!--\n alert(\"$msg\");\n// --></script>";
}
function pama_authenticate($pama_username,$pama_password,$table,$init_login)
{
 db_connect();
 $result=mysql_query("SELECT * FROM pama_".$table." WHERE their_username='$pama_username' AND their_password='$pama_password'");
 if (!mysql_num_rows($result))
 {
  db_close();
  if (!$init_login) js_msg("Error, please re-login. CODE: LEa1");
  $loginerror = "<center><font color=#FF0000><b>Error:</b><br>";
  $loginerror.= "Username and/or password is wrong. Please try again.<br></font>";
  include("logoff.php");
  exit;
 }
}
?>