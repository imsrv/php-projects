<?php include(DIR_LANGUAGES.$language."/".FILENAME_EMAIL_JOB_FORM);?>
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
<script language="Javascript">
<!--
     <?php include(DIR_JS."email_friend.js");?>
//-->
</script>
</head>
<body>
<?php
if ($action == "sent") {
        ?>
        <FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMAIL_JOB, "auth_sess", $bx_session);?>" method="post" name="sendjob" onSubmit="window.close();">
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
         <FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_EMAIL_JOB, "auth_sess", $bx_session);?>" method="post" name="sendjob" onSubmit="return check_friendform();">
            <?php if($error!=0)
                    {
                        echo bx_table_header(ERRORS_OCCURED);
                        echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";
                        if ($jname_error=="1") echo JNAME_ERROR."<br>";
                        if ($jemail_error=="1") echo JEMAIL_ERROR."<br>";
                        if ($fname_error=="1") echo FNAME_ERROR."<br>";
                        if ($femail_error=="1") echo FEMAIL_ERROR."<br>";
                        if ($jmessage_error=="1") echo JMESSAGE_ERROR."<br>";
                        echo "</font>";
                        echo "<INPUT type=\"hidden\" name=\"job_id\" value=\"".$HTTP_POST_VARS['job_id']."\">";
                    }
                    else {
                        if ($HTTP_SESSION_VARS['userid']) {
                                $user_query = bx_db_query("select name, email from ".$bx_table_prefix."_persons where persid = '".$HTTP_SESSION_VARS['userid']."'");
                                SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
                                $user_result = bx_db_fetch_array($user_query);
                                $HTTP_POST_VARS['jname'] = $user_result['name'];
                                $HTTP_POST_VARS['jemail'] = $user_result['email'];
                        }
                    ?>
                        <INPUT type="hidden" name="job_id" value="<?php echo $HTTP_GET_VARS['job_id'];?>">
                     <?php
                          }
                    ?>
                    <INPUT type="hidden" name="action" value="sendjobinemail">
         <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
                <TR>
                        <TD align="right" width="50%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_YOUR_NAME;?>:</font></TD><TD align="left" width="50%"><input type="text" name="jname" value="<?php echo bx_js_stripslashes($HTTP_POST_VARS['jname']);?>"></TD>
                 </TR>
                 <TR>
                        <TD align="right" width="50%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_YOUR_EMAIL;?>:</font></TD><TD align="left" width="50%"><input type="text" name="jemail" value="<?php echo bx_js_stripslashes($HTTP_POST_VARS['jemail']);?>"></TD>
                 </TR>
                 <TR>
                        <TD align="right" width="50%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_FRIEND_NAME;?>:</font></TD><TD align="left" width="50%"><input type="text" name="fname" value="<?php echo bx_js_stripslashes($HTTP_POST_VARS['fname']);?>"></TD>
                 </TR>
                 <TR>
                        <TD align="right" width="50%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_FRIEND_EMAIL;?>:</font></TD><TD align="left" width="50%"><input type="text" name="femail" value="<?php echo bx_js_stripslashes($HTTP_POST_VARS['femail']);?>"></TD>
                 </TR>
                 <TR>
                        <TD align="right" width="50%">&nbsp;</TD><TD align="left"><input type="checkbox" class="radio" name="sendcopy" value="yes"<?php if($HTTP_POST_VARS['sendcopy']=="yes") {echo " checked";}?>><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">&nbsp;<?php echo TEXT_SEND_COPY;?></font></TD>
                 </TR>
                 <TR>
                        <TD align="right" width="50%" valign="top"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_YOUR_MESSAGE;?>:</font></TD><TD align="left" width="50%"><textarea name="jmessage" rows="8" cols="40"><?php echo $HTTP_POST_VARS['jmessage'];?></textarea></TD>
                 </TR>
                 <TR>
                        <TD colspan="2" align="center"><input type="submit" name="sendemail" value="<?php echo TEXT_SEND_EMAIL;?>"></TD>
                 </TR>
          </table>
          </FORM>
        <?php
}
?>
</body>
</html>