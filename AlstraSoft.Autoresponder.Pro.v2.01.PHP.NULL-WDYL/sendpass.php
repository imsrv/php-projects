<?php
/* Nullified by WDYL-WTN */
	$tpl = "pass.tpl";
	
	require("include/template.php");
	require("include/globals.php");
	require("include/db_mysql.php");
	if ($_SERVER['REQUEST_METHOD'] == "POST"){
		mysql_connect( $Host, $User, $Password ) or die ( 'Unable to connect to server.' );
    	mysql_select_db( $Database )   or die ( 'Unable to select database.' );
		
		$r = mysql_query("select * from users where users_username='$username' and users_email='$mail'");
		$tpl = "wr.tpl";
		if (mysql_numrows($r) !=""){
		$q = mysql_fetch_array($r);
		$pass = mktime()*3600/100;
		$password = md5($pass);
		mysql_query("update users set users_password='$password' where users_username='$username'");
		$subject = "New Password";
		$text = "
		Hello $q[users_name]!\n\n
		Your account was changed.
		
		Your login is: $q[users_username] \n
		Password: $pass\n\n
		_________________________________
		Administrator
		";
		$headers = "From: donotreply@_donotreply.com\r\n".
                 "Reply-To: donotreply@_donotreply.com\r\n".
                 "X-Mailer: Gen4ik";
		mail($mail,$subject,$text,$headers);
		
		$tpl = "suc.tpl";
		
		
		}

		
	}
	
	$template = new Template("templates/signin");
	$template->set_file("tpl_signin", "$tpl");
	$template->parse("content", "tpl_signin");
	
	$template->set_file("template_main", "../../login/templates/main.htm");
	$template->set_var("sitename",$SiteName);

	$template->set_var("campaign","");
	$template->set_var("path","");
	$template->parse("main","template_main");
	$template->p("main");
?>