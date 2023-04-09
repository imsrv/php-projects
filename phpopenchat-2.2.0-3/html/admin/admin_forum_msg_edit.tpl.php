<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
    <title> <? echo $MSG_ADM_PAGETITLE; ?></title>
</head>

<body bgcolor="white">

    <br>
    <div align="right">
    <font size="+1"><? echo "$MSG_ADM_FORUM - $MSG_ADM_FORUM_EDITMSG"; ?></font></div>
    <hr><br>

    <? echo "<a href=\"$PHP_SELF?action=messages&topic=$topic\">$MSG_ADM_FORUM_BACKTOLIST</a>"; ?>
    <br><br>

    <? echo "$MSG_ADM_FORUM_NAME : <b>$topic</b>"; ?><br>
    <? echo "$MSG_ADM_FORUM_MSGID : <b>$ID</b>"; ?><br>
    <br>

    <? if ($err_message != "") { ?>
        <br>
        <font color="red">
        <b> <? echo $err_message; ?> </b>
        </font>
        <br><br><br>
    <? } ?>

    <form name="edit_message" action="<? echo "admin_forum.$FILE_EXTENSION"; ?>">

    <table border="1">

    <tr>
        <td><b> <? echo $MSG_ADM_FORUM_DATE; ?></b></td>
        <td><b><? echo $data_date; ?></b></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_FORUM_NICK; ?></b></td>
        <td><input type="text" name="data_name" value="<? echo $data_name; ?>" size="72"></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_FORUM_EMAIL; ?></b></td>
        <td><input type="text" name="data_email" value="<? echo $data_email; ?>" size="72"></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_FORUM_HOMEPAGE; ?></b></td>
        <td><input type="text" name="data_homepage" value="<? echo $data_homepage; ?>" size="72"></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_FORUM_COMMENT; ?></b></td>
        <td><textarea name="data_comment" rows="7" cols="70"><? echo $data_comment; ?></textarea></td>
    </tr>

    </table>

    <br>
    <input type ="hidden" name="action" value="savemsg">
    <input type ="hidden" name="ID" value="<? echo $ID; ?>">
    <input type ="hidden" name="topic" value="<? echo $topic; ?>">
    <input type="submit" name="submit" value=" <? echo $MSG_ADM_SAVE; ?>">

    </form>

</body>
</html>