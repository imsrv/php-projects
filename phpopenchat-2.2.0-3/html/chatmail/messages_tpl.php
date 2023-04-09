<html>
<head>
<title><?echo $CHATMAIL?></title>
</head>
<body bgcolor="#FFFFFF" BACKGROUND="<?echo $CHATSERVERNAME.''.$INSTALL_DIR.'/'.$BG_IMAGE?>" LINK="#0000FF" VLINK="#0000FF" ALINK="#0000FF">
<table width="590">
<tr><td>
<font face="arial, helvetica, sans-serif" size="5"><b>Chatmail - <?echo $chatmail_heading?></b></font><br><br>
<font face="arial, helvetica, sans-serif" size="3"><i><b><?echo$NICK_IS?> &quot;<?echo$nick?>&quot;</b></i></font><br><br>
<font face="arial, helvetica, sans-serif" size="2">[ <?echo $inbox_link?><b><?echo $INBOX?></b></a> | <?echo $write_mail_link?><b><?echo $WRITE_MAIL?></b></a> | <?echo $sent_mail_link?><b><?echo $SENT_MAIL?></b></a> ]</font><br>
<HR SIZE="1" NOSHADE><br>
<FORM ACTION="chatmail_writemail.<?echo$FILE_EXTENSION?>" METHOD="POST">
<INPUT TYPE="hidden" NAME="nick" VALUE="<?echo$nick?>">
<INPUT TYPE="hidden" NAME="pruef" VALUE="<?echo$pruef?>">
<INPUT TYPE="hidden" NAME="<?=session_name()?>" VALUE="<?=session_id()?>">
<font face="arial, helvetica, sans-serif" size="2"><?echo $select_msg_to?></font>
<?echo $show_subjects?>
<?=$content?><BR>
<HR>
<DIV ALIGN="CENTER">
<INPUT type="button" Value="<?echo $CLOSE_WINDOW?>" onClick="window.close()">
</div>
</FORM>
</td></tr></table>
</BODY>
</HTML>