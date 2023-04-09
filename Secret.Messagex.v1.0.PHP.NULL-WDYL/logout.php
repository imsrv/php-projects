<?
require("config.php");
session_start();
$thisuser = $HTTP_SESSION_VARS["thisuser"];

$arrSessions=$HTTP_SESSION_VARS; 
session_destroy(); 
foreach ($arrSessions as $session_name => $session_value) { 
	unset($$session_name); 
	} 
unset($arrSessions);

print stripslashes($header);
?>

<b><font face="Trebuchet MS, Arial" color=#FF7E15 size=3>Logout</font></b>
<p>
You have successfully logged out.

<?
print stripslashes($footer);
?>