<?php
include("phpdbform/phpdbform_core.php");
if( AUTHDBFORM == "cookies" ) {
	unset( $AuthName );
	unset( $AuthPasswd );
} else {
	session_start();
	$AuthName="";
	$AuthPasswd="";
	session_unregister("AuthName");
	session_unregister("AuthPasswd");
}
print_header("logout");
?>
<br><br><div align="center"><font color="Green" face="Verdana" size="18px"><b>
<?php print( MSG_BYE ); ?>
</b></font></div><br><br>
<?php
print_logos(false);
print_tail();
?>