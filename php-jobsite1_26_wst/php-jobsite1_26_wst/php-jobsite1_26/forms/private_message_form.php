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
if($HTTP_GET_VARS['apply_id'] || $HTTP_POST_VARS["apply_id"]) {
$apply_query = bx_db_query("select * from ".$bx_table_prefix."_jobapply,".$bx_table_prefix."_persons where applyid='".(($HTTP_GET_VARS['apply_id'])?$HTTP_GET_VARS['apply_id']:$HTTP_POST_VARS['apply_id'])."' and ".$bx_table_prefix."_jobapply.compid='".$HTTP_SESSION_VARS['employerid']."' and ".$bx_table_prefix."_persons.persid=".$bx_table_prefix."_jobapply.persid");
SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
$apply_result = bx_db_fetch_array($apply_query);
        if ($action == "sent") {
                ?>
                <FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_PRIVATE, "auth_sess", $bx_session);?>" method="post" name="sendprivate" onSubmit="window.close();">
                <table bgcolor=<?php echo TABLE_BGCOLOR;?> width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
                        <TR>
                                <TD align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SUCCESSFULL_SENT."&nbsp;";?>.</font></TD>
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
                 <FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_PRIVATE, "auth_sess", $bx_session);?>" method="post" name="sendprivate" onSubmit="if(this.private_message.value==''){alert('<?php echo eregi_replace("'","&#034;",MESSAGE_ERROR);?>'); return false;} else {return true;}">
                 <INPUT type="hidden" name="action" value="sendprivate">
                 <INPUT type="hidden" name="apply_id" value="<?php echo ($HTTP_GET_VARS['apply_id'])?$HTTP_GET_VARS['apply_id']:$HTTP_POST_VARS['apply_id'];?>">
                 <?php if($error!=0) {
                                echo bx_table_header(ERRORS_OCCURED);
                                echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";
                                if ($message_error=="1") echo MESSAGE_ERROR."<br>";
                                echo "</font>";
                 }?>
                 <table bgcolor=<?php echo TABLE_BGCOLOR;?> width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
                         <TR>
                                <TD width="100%" valign="top" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_YOUR_MESSAGE;?></font></TD>
                         </TR>       
                         <TR>
                                <TD align="center" width="100%"><textarea name="private_message" rows="15" cols="60"><?php echo $HTTP_POST_VARS['message'];?></textarea></TD>
                         </TR>
                         <TR>
                             <TD>&nbsp;</TD>
                         </TR>
                         <TR>
                                <TD align="center"><input type="submit" name="sendemail" value="<?php echo TEXT_SEND_MESSAGE;?>"></TD>
                         </TR>
                         <TR>
                             <TD align="right">&nbsp;&nbsp;&nbsp;<a href="javascript: window.close();"><?php echo TEXT_CLOSE_WINDOW;?></a></TD>
                         </TR>
                  </table>
                  </FORM>
                <?php
        }
}
elseif($HTTP_GET_VARS['company_id'] || $HTTP_POST_VARS['company_id']) {
        $company_query = bx_db_query("select company, compid from ".$bx_table_prefix."_companies where compid='".(($HTTP_GET_VARS['company_id'])?$HTTP_GET_VARS['company_id']:$HTTP_POST_VARS['company_id'])."'");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        $company_result = bx_db_fetch_array($company_query);
        if ($action == "sent") {
                ?>
                <FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_PRIVATE, "auth_sess", $bx_session);?>" method="post" name="sendprivate" onSubmit="window.close();">
                <table bgcolor=<?php echo TABLE_BGCOLOR;?> width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
                        <TR>
                                <TD align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SUCCESSFULL_SENT."&nbsp;";?>.</font></TD>
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
                 <FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_PRIVATE, "auth_sess", $bx_session);?>" method="post" name="sendjob" onSubmit="if(this.private_message.value==''){alert('<?php echo eregi_replace("'","&#034;",MESSAGE_ERROR);?>'); return false;} else {return true;}">
                 <INPUT type="hidden" name="action" value="sendprivate">
                 <INPUT type="hidden" name="company_id" value="<?php echo ($HTTP_GET_VARS['company_id'])?$HTTP_GET_VARS['company_id']:$HTTP_POST_VARS['company_id'];?>">
                 <?php if($error!=0) {
                                echo bx_table_header(ERRORS_OCCURED);
                                echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";
                                if ($email_error=="1") echo EMAIL_ERROR."<br>";
                                if ($password_error=="1") echo PASSWORD_ERROR."<br>";
                                if ($message_error=="1") echo MESSAGE_ERROR."<br>";
                                echo "</font>";
                 }?>
                 <table bgcolor=<?php echo TABLE_BGCOLOR;?> width="100%" border="0" cellspacing="1" cellpadding="2" align="center">
                         <?php if(!$HTTP_SESSION_VARS['userid']){?>
                         <TR>
                                <TD width="35%" valign="top" align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_USER_NAME;?>:</b></font></TD>
                               <TD width="65%"><INPUT type="text" name="user" size="20" value="<?php echo $HTTP_POST_VARS['user'];?>"></TD>
                         </TR>
                         <TR>                         
                                    <TD width="35%" align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_PASSWORD;?>:</b></font></TD>
                                    <TD width="65%"><INPUT type="password" name="passw" size="20" value="<?php echo $HTTP_POST_VARS['passw'];?>">
                                </TD>
                         </TR>       
                         <?php }else{?>
                         <TR>
                             <td colspan="2">&nbsp;</td>
                         </TR>
                         <TR>
                             <td colspan="2">&nbsp;</td>
                         </TR>
                         <?php }?>
                         <TR>
                                <TD width="100%" valign="top" align="center" colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_YOUR_MESSAGE;?></font></TD>
                         </TR>       
                         <TR>
                                <TD align="center" width="100%" colspan="2"><textarea name="private_message" rows="15" cols="60"><?php echo $HTTP_POST_VARS['private_message'];?></textarea></TD>
                         </TR>
                         <TR>
                             <TD colspan="2">&nbsp;</TD>
                         </TR>
                         <TR>
                                <TD align="center" colspan="2"><input type="submit" name="sendemail" value="<?php echo TEXT_SEND_MESSAGE;?>"></TD>
                         </TR>
                         <TR>
                             <TD align="right" colspan="2">&nbsp;&nbsp;&nbsp;<a href="javascript: window.close();"><?php echo TEXT_CLOSE_WINDOW;?></a></TD>
                         </TR>
                  </table>
                  </FORM>
                <?php
        }
}
elseif($HTTP_GET_VARS['person_id'] || $HTTP_POST_VARS['person_id']) {
        $person_query = bx_db_query("select name from ".$bx_table_prefix."_persons where persid='".(($HTTP_GET_VARS['person_id'])?$HTTP_GET_VARS['person_id']:$HTTP_POST_VARS['person_id'])."'");
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        $person_result = bx_db_fetch_array($person_query);
        if ($action == "sent") {
                ?>
                <FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_PRIVATE, "auth_sess", $bx_session);?>" method="post" name="sendprivate" onSubmit="window.close();">
                <table bgcolor=<?php echo TABLE_BGCOLOR;?> width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
                        <TR>
                                <TD align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_SUCCESSFULL_SENT."&nbsp;";?>.</font></TD>
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
                 <FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_PRIVATE, "auth_sess", $bx_session);?>" method="post" name="sendjob" onSubmit="if(this.private_message.value==''){alert('<?php echo eregi_replace("'","&#034;",MESSAGE_ERROR);?>'); return false;} else {return true;}">
                 <INPUT type="hidden" name="action" value="sendprivate">
                 <INPUT type="hidden" name="person_id" value="<?php echo ($HTTP_GET_VARS['person_id'])?$HTTP_GET_VARS['person_id']:$HTTP_POST_VARS['person_id'];?>">
                 <?php if($error!=0) {
                                echo bx_table_header(ERRORS_OCCURED);
                                echo "<font face=\"".ERROR_TEXT_FONT_FACE."\" size=\"".ERROR_TEXT_FONT_SIZE."\" color=\"".ERROR_TEXT_FONT_COLOR."\">";
                                if ($message_error=="1") echo MESSAGE_ERROR."<br>";
                                echo "</font>";
                 }?>
                 <table bgcolor=<?php echo TABLE_BGCOLOR;?> width="100%" border="0" cellspacing="1" cellpadding="1" align="center">
                         <TR>
                                <TD width="100%" valign="top" align="center" colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo TEXT_YOUR_MESSAGE;?></font></TD>
                         </TR>       
                         <TR>
                                <TD align="center" width="100%" colspan="2"><textarea name="private_message" rows="15" cols="60"><?php echo $HTTP_POST_VARS['private_message'];?></textarea></TD>
                         </TR>
                         <TR>
                             <TD colspan="2">&nbsp;</TD>
                         </TR>
                         <TR>
                                <TD align="center" colspan="2"><input type="submit" name="sendemail" value="<?php echo TEXT_SEND_MESSAGE;?>"></TD>
                         </TR>
                         <TR>
                             <TD align="right" colspan="2">&nbsp;&nbsp;&nbsp;<a href="javascript: window.close();"><?php echo TEXT_CLOSE_WINDOW;?></a></TD>
                         </TR>
                  </table>
                  </FORM>
                <?php
        }
}
?>
</body>
</html>