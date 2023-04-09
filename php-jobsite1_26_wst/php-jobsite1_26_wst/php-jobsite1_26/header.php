<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo SITE_TITLE;?></title>
<?php echo META;?><!-- kactus_man2003[WST -->
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $CHARSET_OPTION;?>">
<script language="Javascript">
<!--
 if (navigator.appName == "Netscape") {
	  if(navigator.userAgent.indexOf("Netscape6") > 0) {
         document.write("<link rel=\"stylesheet\" href=\"<?php echo $css_file_dir;?>css.php\" type=\"text/css\">");
      } else {
	  	 if(navigator.userAgent.indexOf("4.") > 0) {
        	document.write("<link rel=\"stylesheet\" href=\"<?php echo $css_file_dir;?>css.php?type=ns\" type=\"text/css\">");
      	 } else {
		 	document.write("<link rel=\"stylesheet\" href=\"<?php echo $css_file_dir;?>css.php\" type=\"text/css\">");
		 }
	  }
   }
else if (navigator.userAgent.indexOf("MSIE") > 0) {
      document.write("<link rel=\"stylesheet\" href=\"<?php echo $css_file_dir;?>css.php\" type=\"text/css\">");
}
else {
      document.write("<link rel=\"stylesheet\" href=\"<?php echo $css_file_dir;?>css.php\" type=\"text/css\">");
}
//-->
</script>
<noscript>
    <link rel="stylesheet" href="<?php echo $css_file_dir;?>css.php" type="text/css">
</noscript>
<?php
if (!empty($jsfile)) {
     echo "\n<script language=\"JavaScript1.1\">";
     echo "\n<!--\n";
     include(DIR_JS.$jsfile);
     echo "\n//-->\n</script>\n";
}
?>
</head>
<body>
<!-- header //-->
<table border="0" width="<?php echo HTML_WIDTH;?>" cellspacing="1" cellpadding="2" align="center">
 <tr>
 <td width="100%">
 <?php
   @include(DIR_LANGUAGES.$language.'/html/header.html');
   if (SHOW_STATISTICS_BAR == "yes") {
	include(DIR_FORMS."site_stat_form.php");
   }
?>
 </td>
 </tr>
</table>
<!-- header_eof //-->
<!-- body //-->
<table border="0" width="<?php echo HTML_WIDTH;?>" cellspacing="1" cellpadding="2" align="center">
 <tr>
 <!-- left_navigation //-->
 <?php
 if (!$HTTP_SESSION_VARS['employerid'] && !$HTTP_POST_VARS['compid'] ) {
 ?>
 <td valign="top"  width="<?php echo LEFT_NAVIGATION_WIDTH;?>">
  <table border="0" cellspacing="0" cellpadding="1" width="100%" height="100%">
     <tr>
      <td width="100%" align="center" bgcolor="#000000">
      <?php
      include(DIR_LANGUAGES.$language."/".FILENAME_LEFT_NAVIGATION);
      if ($HTTP_SESSION_VARS['userid']){
          include(DIR_LANGUAGES.$language.'/html/left_navigation_logged.php');
      }
      else {
          include(DIR_LANGUAGES.$language.'/html/left_navigation_notlogged.php');
      }
      ?>
      </td>
     </tr>
  </table>
 </td>
 <?php
 }
 ?>
 <!-- end left_navigation //-->
 <!-- body_navigation //-->
 <td valign="top" width="<?php echo MAIN_NAVIGATION_WIDTH;?>">
 <table border="0" cellspacing="1" cellpadding="0" width="100%">
     <tr>
      <td width="100%">