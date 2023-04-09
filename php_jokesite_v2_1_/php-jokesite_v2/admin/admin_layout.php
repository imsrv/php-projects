<?
if ($HTTP_POST_VARS['todo']=="preview") {
	$language = DEFAULT_LANGUAGE;
   while (list($header, $value) = each($HTTP_POST_VARS)) {
      if ( ($header != "action") && ($header != "save")) {
           $value = stripslashes($value);
           if (eregi(".*'.*", $value, $regs)) {
                $value = eregi_replace("'","\"",$value);
           }
           eval("define('".$header."','".$value."');");
      }
      }//end while (list($header, $value) = each($HTTP_POST_VARS))


	include ("../config_file.php");
	include (DIR_SERVER_ROOT."header.php");
	include (DIR_SERVER_ROOT."footer.php");
	exit;
}


include("../config_file.php");
include (DIR_SERVER_ADMIN."admin_setting.php");

$this_file_name = basename($HTTP_SERVER_VARS['PHP_SELF']);
$page_title = "Layout manager";
?>

<script language="Javascript" src="admin_layout.js"></script>

<?
include (DIR_SERVER_ADMIN."admin_header.php");
include(DIR_SERVER_ADMIN."admin_layout_form.php");
include(DIR_SERVER_ADMIN."admin_footer.php");
?>