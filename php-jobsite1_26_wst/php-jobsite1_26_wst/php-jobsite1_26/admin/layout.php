<?php
if ($HTTP_POST_VARS['todo']=="preview") {
   function bx_local_stripslashes($str){
        if (get_magic_quotes_gpc()) {
            return stripslashes($str);
        }
        else {
            return $str;
        }
   }
   while (list($header, $value) = each($HTTP_POST_VARS)) {
      if ( ($header != "action") && ($header != "save")) {
           $value = bx_local_stripslashes($value);
           if (eregi(".*'.*", $value, $regs)) {
                $value = eregi_replace("'","\"",$value);
           }
           eval("define('".$header."','".$value."');");
      }
   }//end while (list($header, $value) = each($HTTP_POST_VARS))
   define('LEFT_NAVIGATION_WIDTH','20%');
   define('RIGHT_NAVIGATION_WIDTH','20%');
   define('MAIN_NAVIGATION_WIDTH','50%');
   include('admin_design.php');
   include('../application_config_file.php');
   include('admin_auth.php');
   include(DIR_LANGUAGES.$language."/".FILENAME_SEARCH_RESUMES);
   $jsfile="search.js";
   $css_file_dir="../";
   include(DIR_SERVER_ROOT."header.php");
   include(DIR_FORMS.FILENAME_SEARCH_JOB_FORM);
   include(DIR_SERVER_ROOT."footer.php");
   bx_exit();
}
include('admin_design.php');
include('../application_config_file.php');
include('admin_auth.php');
$jsfile = "admin_layout.js";
include("header.php");
include(DIR_ADMIN.FILENAME_ADMIN_LAYOUT_FORM);
include("footer.php");
?>