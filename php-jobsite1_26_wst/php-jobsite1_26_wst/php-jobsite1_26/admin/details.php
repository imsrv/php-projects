<?php
include ('admin_design.php');
include ('../application_config_file.php');
include ('admin_auth.php');
if ($HTTP_GET_VARS['printit']=="yes") {
    echo "<html><head><title>Invoice details:".$HTTP_GET_VARS['opid']."</title>";
    echo "<SCRIPT Language=\"Javascript\">\n";
    echo "function printit(){  \n";
    echo "var navver = parseInt(navigator.appVersion);\n";
    echo "if (navver > 3) {\n";
    echo "   if (window.print) {\n";
    echo "        parent.pmain.focus();\n";
    echo "        window.print() ;\n";  
    echo "    }\n";
    echo "}\n";
    echo "return false;\n";
    echo "}\n";
    echo "</script>\n";
    echo "</head><body>\n";
}
else {
    include("header.php");
}
include(DIR_ADMIN.FILENAME_ADMIN_DETAILS_FORM);
if ($HTTP_GET_VARS['printit']=="yes") {
    echo "</body></html>";
    bx_exit();
}
else {
    include("footer.php");
}
?>