<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
  <title> <? echo $MSG_ADM_PAGETITLE; ?></title>
</head>
<body bgcolor="lightgrey">

<center>
<br>

<font size="+1"><b> <? echo $MSG_ADM_PAGETITLE; ?> </b></font>
<br><hr><br>

<a href="<? echo "$ADMIN_DIR/admin_channels.$FILE_EXTENSION"; ?>" target="module"><? echo $MSG_ADM_CHANNELS; ?></a><br><br>
<a href="<? echo "$ADMIN_DIR/admin_operators.$FILE_EXTENSION"; ?>" target="module"><? echo $MSG_ADM_OPERATORS; ?></a><br><br>
<a href="<? echo "$ADMIN_DIR/admin_vips.$FILE_EXTENSION"; ?>" target="module"> <? echo $MSG_ADM_VIPS; ?></a><br><br>
<a href="<? echo "$ADMIN_DIR/admin_comoderators.$FILE_EXTENSION"; ?>" target="module"><? echo $MSG_ADM_COMODERATORS; ?></a><br><br>
<a href="<? echo "$ADMIN_DIR/admin_hints.$FILE_EXTENSION"; ?>" target="module"> <? echo $MSG_ADM_HINTS; ?></a><br><br>
<a href="<? echo "$ADMIN_DIR/admin_forum.$FILE_EXTENSION"; ?>" target="module"> <? echo $MSG_ADM_FORUM; ?></a><br><br>
<a href="<? echo "$ADMIN_DIR/admin_mailall.$FILE_EXTENSION"; ?>" target="module"> <? echo $MSG_ADM_MAILALL; ?></a><br><br>
<a href="<? echo $INSTALL_DIR; ?>" target="_top"> <? echo $MSG_ADM_BACKTOCHAT; ?></a><br><br>

</center>

</body>
</html>