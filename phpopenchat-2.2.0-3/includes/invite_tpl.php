<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
<head>
<title><?echo$MSG_INVITE?></title>
</head>
<body BACKGROUND="<?echo $BG_IMAGE?>" bgcolor="#FFFFFF" LINK="#0000FF" VLINK="#0000FF" ALINK="#0000FF">
<table width="590">
  <tr>
    <td>
      <font face="arial,helvetica,sans-serif" size="5"><b><?echo $MSG_INVITE_TITLE?></b></font><br><br>
      <font face="arial,helvetica,sans-serif" size="2">[ <A HREF="invite.<?echo $FILE_EXTENSION.'?nick='.urlencode($nick).'&pruef='.$pruef.'&'.session_name().'='.session_id();?>"><b><?echo $MSG_INVITE?></b></a> | <A HREF="ignore.<?echo $FILE_EXTENSION.'?nick='.urlencode($nick).'&pruef='.$pruef.'&'.session_name().'='.session_id();?>"><b><?echo $MSG_IGNORE?></b></a> ]</font><br>
      <HR>
      <FORM ACTION="<?echo$INSTALL_DIR?>/invite.<?echo $FILE_EXTENSION?>" METHOD="POST">
	<TABLE ALIGN="CENTER" BORDER="0">
	  <TR>
	    <TD ALIGN="CENTER">
	      <font face="arial,helvetica,sans-serif" size="2"><?echo$MSG_INVITE_LIST?></font>
	    </TD>
	    <TD WIDTH="50"></TD>
	    <TD ALIGN="CENTER">
	      <font face="arial,helvetica,sans-serif" size="2"><?echo$ALL_CHATTER?></font>
	      <?echo$permissions?>
	    </TD>
	  </TR>
	  <TR>
      </FORM>
      <FORM ACTION="<?echo$SCRIPT_NAME?>" METHOD="POST">
	    <TD ALIGN="CENTER">
	      <?echo $select_of_invited_chatter?>
	    </TD>
	    <TD ALIGN="CENTER" VALIGN="CENTER">
	      <INPUT NAME="rein" TYPE="submit" VALUE="« --"><BR>
	      <INPUT NAME="raus" TYPE="submit" VALUE="-- »">
	    </TD>
	    <TD ALIGN="CENTER">
	      <?echo $select_of_not_invited?>
	      <?echo$permissions?>
	    </TD>
	  </TR>
	</TABLE>
	<BR>
	<HR>
	<BR>
	<DIV ALIGN="CENTER"><INPUT type="button" Value=" <?echo$CLOSE_WINDOW?> " onClick="window.close()"></DIV>
      </FORM>
    </td>
  </tr>
</table>
</body>
</html>


