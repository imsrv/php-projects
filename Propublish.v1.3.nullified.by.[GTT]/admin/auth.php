<?
// --------------------------------------------------
// Autentifiseringsmodul
// --------------------------------------------------
?>

<?
// Derson det ikke er registrert en sesjon
if (!session_is_registered(email) OR !session_is_registered(userid) OR !session_is_registered(level))
{
	global $skip;
	print "<h3>$la_member_funk_info</h3>";
	print $la_demands_login;
	if (!$skip) { 	include "../footer.php"; };
	exit;
}
// Derson en person pr�ver � komme til en side han ikke har h�y
// nok autorisasjon for.
elseif (session_is_registered(email) AND (($level > $req_level)))
{
	global $la_member_funk_info;
	global $la_member_funk1;
	global $la_member_funk2;
	
	print "<h2>$la_member_funk_info</h2>";
	print "$la_member_funk_1 $level, $la_member_funk2 $req_level";
	if (!$skip) { 	include "../footer.php"; };
	exit;
}
print "<br><span class='articlebody'>$la_login_as ";
print $email;
print " $la_withlevel $level.</span>";
/*
	Pro Publish v1.3
	Nullified by GTT
*/
?>