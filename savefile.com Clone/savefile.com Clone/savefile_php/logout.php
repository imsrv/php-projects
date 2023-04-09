<?
	session_start();
	session_destroy();
	include("include/common.php");
	if ($loggedin){
		if ($logout) {
			$myname = "";
			$myrights = "";
			$myemail = "";
			$loggedin = 0;
			session_register("loggedin");
			session_register("myname");
			session_register("myuid");
			session_register("myrights");
			session_register("myemail");
			$failed = 1;
		}
	}
	header("Location: index.php");
?>