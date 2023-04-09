<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
<head>
<title><?echo$MSG_IGNORE?></title>
</head>
<body BACKGROUND="<?echo$BG_IMAGE?>" bgcolor="#FFFFFF" LINK="#0000FF" VLINK="#0000FF" ALINK="#0000FF">
<table width="590">
  <tr>
    <td>
      <font face="arial,helvetica,sans-serif" size="5"><b><?echo $MSG_IGNORE?></b></font><br><br>
      <font face="arial,helvetica,sans-serif" size="2">[ <A HREF="invite.<?echo $FILE_EXTENSION.'?nick='.urlencode($nick).'&pruef='.$pruef.'&'.session_name().'='.session_id();?>"><b><?echo $MSG_INVITE?></b></a> | <A HREF="ignore.<?echo $FILE_EXTENSION.'?nick='.urlencode($nick).'&pruef='.$pruef.'&'.session_name().'='.session_id();?>"><b><?echo $MSG_IGNORE?></b></a> ]</font><br>
      <HR>
      <font face="arial,helvetica,sans-serif" size="2" color="#ff0000"><?echo$paten_msg?></font>
      <font face="arial,helvetica,sans-serif" size="2" color="#ff0000"><?echo$ignore_hint?></font>
      <FORM ACTION="<?echo$INSTALL_DIR.'/ignore.php'?>" METHOD="POST">
	<TABLE ALIGN="CENTER" BORDER="0">
	  <TR>
	    <TD ALIGN="CENTER">
	      <font face="arial,helvetica,sans-serif" size="2"><?echo$MSG_IGNORE_LIST?></font>
	    </TD>
	    <TD WIDTH="50"></TD>
	    <TD ALIGN="CENTER">
	      <font face="arial,helvetica,sans-serif" size="2"><?echo$ALL_CHATTER?></font>
	    </TD>
	  </TR>
	  <TR>
	    <TD ALIGN="CENTER">
	      <?echo$permissions?>
	      <?echo$select_of_ignored_chatter?>
	    </TD>
	    <TD ALIGN="CENTER" VALIGN="MIDDLE">
	      <INPUT NAME="add" TYPE="submit" VALUE="« --">
	      <BR>
	      <INPUT NAME="del" TYPE="submit" VALUE="-- »">
	    </TD>
	    <TD ALIGN="CENTER">
	      <?echo$select_of_all_chatters?>
	    </TD>
	  </TR>
	</TABLE>
	<BR>
	<HR>
	<BR>
	<DIV ALIGN="CENTER"><INPUT type="button" Value=" <?echo$CLOSE_WINDOW?> " onClick="window.close()"></DIV>
      </FORM>
    </TD>
  </TR>
</TABLE>
</body>
</html>

