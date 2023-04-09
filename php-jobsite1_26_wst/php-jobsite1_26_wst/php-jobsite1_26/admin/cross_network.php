<?php
if ($HTTP_POST_VARS['todo']=="preview") {
   include ('admin_design.php');
   include ('../application_config_file.php');
   include ('admin_auth.php');
   ?>
   <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
    <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="history" content="">
    <meta name="author" content="Copyright © 2002-2003 - BitmixSoft. All rights reserved.">
    <title>Cross Network Options - <?php echo $HTTP_POST_VARS['type'];?> - Preview</title>
    </head>
    <body>
    <center>
    <?php echo bx_stripslashes($HTTP_POST_VARS['html_code']);?>
    </center>
    </body>
    </html>
   <?php
   bx_exit();
}
elseif ($HTTP_GET_VARS['todo']=="customize") {
    include('../application_config_file.php');
    include('admin_design.php');
}
else {
 include('admin_design.php');
 include('../application_config_file.php');
}
include('admin_auth.php');
include(DIR_LANGUAGES.$language."/".FILENAME_ADMIN_FORM);
if ($HTTP_GET_VARS['todo']=="customize") {
    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
    <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="history" content="">
    <meta name="author" content="Copyright © 2002-2003 - BitmixSoft. All rights reserved.">
    <title>Cross Network Options - Customization</title>
    <style type="text/css" title="">
    <!--
     TD {font-size: 12px;}
     INPUT {font-size: 12px;}
     .button {font-size: 12px; font-weight: bold; color:#FFFFFF; background: #999999;}
     //-->
    </style>
    <?php
    echo "\n<script language=\"JavaScript1.1\">";
    echo "\n<!--\n";
    include(DIR_JS."admin_layout.js");
    echo "\n//-->\n</script>\n";
    ?>
    <script language="Javascript">
    <!--
    function replace_slash(str){
        str.replace(/a/gi,"sss");
        alert(str);   
        return str;
    }
    function make_html_code(){
        document.customize.html_code.value="<script language=\"Javascript\">\n";
        document.customize.html_code.value+="<!--\n";
        if (document.customize.pjs_title) {
            document.customize.html_code.value+="var pjs_title='"+document.customize.pjs_title.value.replace(/'/gi,"&#039;")+"';\n";
        }   
        if (document.customize.pjs_titleBGColor) {
            document.customize.html_code.value+="var pjs_titleBGColor='"+document.customize.pjs_titleBGColor.value+"';\n";
        }
        if (document.customize.pjs_bigFont) {
            document.customize.html_code.value+="var pjs_bigFont='"+document.customize.pjs_bigFont.value.replace(/'/gi,"&#039;")+"';\n";
        }
        if (document.customize.pjs_tableBGColor) {
            document.customize.html_code.value+="var pjs_tableBGColor='"+document.customize.pjs_tableBGColor.value+"';\n";
        }
        if (document.customize.pjs_headerFont) {
            document.customize.html_code.value+="var pjs_headerFont='"+document.customize.pjs_headerFont.value.replace(/'/gi,"&#039;")+"';\n";
        }
        if (document.customize.pjs_headerBGColor) {
            document.customize.html_code.value+="var pjs_headerBGColor='"+document.customize.pjs_headerBGColor.value+"';\n";
        }    
        if (document.customize.pjs_borderColor) {
            document.customize.html_code.value+="var pjs_borderColor='"+document.customize.pjs_borderColor.value+"';\n";
        }
        if (document.customize.pjs_rowBGColor1) {
            document.customize.html_code.value+="var pjs_rowBGColor1='"+document.customize.pjs_rowBGColor1.value+"';\n";
        }
        if (document.customize.pjs_rowBGColor2) {
            document.customize.html_code.value+="var pjs_rowBGColor2='"+document.customize.pjs_rowBGColor2.value+"';\n";
        }
        if (document.customize.pjs_linkStyle) {
            document.customize.html_code.value+="var pjs_linkStyle='"+document.customize.pjs_linkStyle.value.replace(/'/gi,"&#039;")+"';\n";
        }
        document.customize.html_code.value+="//-->\n";
        document.customize.html_code.value+="</script"+">\n";
        document.customize.html_code.value+="<script language=\"Javascript\" src=\"<?php echo HTTP_SERVER;
        if($HTTP_GET_VARS['type']=="ljobs"){ echo "latest_jobs.php";}elseif($HTTP_GET_VARS['type']=="fjobs"){echo "featured_jobs.php";}elseif($HTTP_GET_VARS['type']=="fcomp"){echo "featured_companies.php";}elseif($HTTP_GET_VARS['type']=="compjobs"){echo "company_jobs.php";}?>";
        var lng_add=0;
        if (document.customize.language) {
            document.customize.html_code.value+="?language="+document.customize.language.value;
            lng_add=1;
        }
        else {
            lng_add=0;
        }
        <?php if($HTTP_GET_VARS['type']=="compjobs"){?>
        if (lng_add==1) {
            document.customize.html_code.value+="&"; 
        }   
        else {
            document.customize.html_code.value+="?";
        }
        document.customize.html_code.value+="company_id="+opener.document.compjobs.compid.value;
        <?php }?>
        document.customize.html_code.value+="\"></script"+">";
    }
    
    function return_and_close(){
       opener.document.<?php echo $HTTP_GET_VARS['type'];?>.html_code.value=document.customize.html_code.value;
       self.window.close();
    }
    //-->
    </script>
    </head>
    <body bgcolor="#EFEFEF">
    <center>
    <?php
    include(DIR_ADMIN."cross_network_customize.php");
}
else {
   $jsfile = "admin_mail.js";
    include("header.php");
    include(DIR_ADMIN."cross_network_form.php");
}
if ($HTTP_GET_VARS['todo']=="customize") {
    ?>
    </center>
    </body>
    </html>
    <?php
}
else {
    include("footer.php");
}    
?>