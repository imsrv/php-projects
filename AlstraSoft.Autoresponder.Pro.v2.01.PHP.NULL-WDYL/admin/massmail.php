<?
/* Nullified by WDYL-WTN */
require("include/everything.php");
	if ($_SERVER['REQUEST_METHOD'] == "POST"){
	mysql_connect( $Host, $User, $Password ) or die ( 'Unable to connect to server.' );
    mysql_select_db( $Database )   or die ( 'Unable to select database.' );
	$headers = "From: donotreply@_donotreply.com\r\n".
                 "Reply-To: donotreply@_donotreply.com\r\n".
                 "X-Mailer: Gen4ik";
	$r= mysql_query ("select * from users");
	while ($q = mysql_fetch_array($r)){
		mail($q[users_email],$subject,$message,$headers);
	}	
	}
	$template = new Template("templates/members_list");
	$template->set_file("tpl_members_list", "m_zero1.tpl");
	if ($_SERVER['REQUEST_METHOD'] != "POST"){
	$dt = "<tr><td bgcolor=white>
	<form action=massmail.php method=post>
	<table width=100% cellPadding=5 cellSpacing=0 border=0>
	<tr><td>Subject:</td>
	<td><input type=text name=subject></td></tr>
	<tr><td>Message:</td>
	<td><textarea name=message cols=50 rows=10></textarea></td></tr>
	<tr><td></td>
	<td><input type=submit value='Send Mail To All Members'></td></tr>
	</table>
	</form>
	</td></tr>";
	} else{
		$dt = "<tr><td bgcolor=white>Message was sent succesfully</td></tr>";
	}
	$template->set_var("ACCOUNTTYPE_LIST", $dt);
	
	$template->parse("output", "tpl_members_list");
	$template->p("output");
?>