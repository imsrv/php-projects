<?php include(DIR_LANGUAGES.$language."/email_resume_form.php");?>
<html>
<head>
<title><?php echo SITE_TITLE;?></title>
<?php echo META;?>
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
</head>
<body>
<?php
if ($action == "sent") {
        ?>
        <FORM action="<?php echo bx_make_url(HTTP_SERVER."email_resume.php", "auth_sess", $bx_session);?>" method="post" name="sendjob" onSubmit="window.close();">
        <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
                <TR>
                        <TD align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SUCCESSFULL_SENT;?>:</font></TD>
                 </TR>
                 <TR>
                        <TD align="center">&nbsp;</TD>
                 </TR>
                 <TR>
                        <TD align="center"><input type="submit" name="closebrowser" value="<?php echo TEXT_CLOSE_WINDOW;?>"></TD>
                 </TR>
          </table>
          </FORM>
        <?php
}
else {
        ?>
         <FORM action="<?php echo bx_make_url(HTTP_SERVER."email_resume.php", "auth_sess", $bx_session);?>" method="post" name="sendresume" onSubmit="if (this.rsubject.value == '') {alert('<?php echo TEXT_SUBJECT_ERROR;?>'); return false;} else {return true;}">
            <INPUT type="hidden" name="action" value="sendresumeinemail">
            <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
                <TR>
                        <TD align="right" width="30%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SUBJECT;?>:</font></TD><TD align="left" width="70%"><input type="text" name="rsubject" value=""></TD>
                 </TR>
                 <TR>
                        <TD align="right" width="30%" valign="top"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_COMMENT;?>:</font></TD><TD align="left" width="70%"><textarea name="jmessage" rows="8" cols="40"><?php echo $HTTP_POST_VARS['jmessage'];?></textarea></TD>
                 </TR>
                 <TR>
                        <TD align="right" width="30%" valign="top">&nbsp;</TD><TD align="left"><input type="submit" name="sendemail" value="<?php echo TEXT_SEND_EMAIL;?>"></TD>
                 </TR>
            </table>
          </FORM>
        <?php
}
?>
</body>
</html>