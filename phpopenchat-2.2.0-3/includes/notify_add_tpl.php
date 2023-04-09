<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
<head>
<title><?echo$NOTIFY?></title>
</head>
<body BACKGROUND="<?echo $BG_IMAGE?>" bgcolor="#FFFFFF" LINK="#0000FF" VLINK="#0000FF" ALINK="#0000FF">
<table width="590">
  <tr>
    <td>	
      <font face="arial,helvetica,sans-serif" size="5"><b><?echo$NOTIFY?></b></font><br><br>
      <font face="arial,helvetica,sans-serif" size="2">[ <A HREF="chat_notify.<?echo $FILE_EXTENSION.'?action=list&nick='.urlencode($nick).'&pruef='.$pruef.'&'.session_name().'='.session_id();?>"><b><?echo $MSG_FRIENDS?></b></a> | <A HREF="chat_notify.<?echo $FILE_EXTENSION.'?action=add&nick='.urlencode($nick).'&pruef='.$pruef.'&'.session_name().'='.session_id();?>"><b><?echo $MSG_FRIENDS_ADD?></b></a> ]</font><br>
      <HR>
      <FORM ACTION="chat_notify.<?echo$FILE_EXTENSION?>" METHOD="POST">
	<?echo $search_for_chatter?>
	<?echo $show_search_result?>
	<?echo $add_button?>
        <br><br>
        <HR>
      </FORM>
      <div align="center">
      <FORM>
        <INPUT type="button" Value=" <?echo$CLOSE_WINDOW?> " onClick="window.close()">
      </FORM>
      </div>
    </td>
  </tr>
</table>
</body>
</html>

