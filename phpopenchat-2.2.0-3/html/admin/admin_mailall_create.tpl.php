<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
    <title> <? echo $MSG_ADM_PAGETITLE; ?></title>
</head>

<body bgcolor="white">

    <br>
    <div align="right">
    <font size="+1"> <? echo "$MSG_ADM_MAILALL - $MSG_ADM_MAILALL_NEWMAIL"; ?></font></div>
    <hr><br>

    <? if ($err_message != "") { ?>
        <br>
        <font color="red">
        <b> <? echo $err_message; ?> </b>
        </font>
        <br><br><br>
    <? } ?>

    <form name="create_massmail" action="<? echo "admin_mailall.$FILE_EXTENSION"; ?>">

    <table border="1">

    <tr>
        <td><b> <? echo $MSG_ADM_MAILALL_RECIEVER; ?></b></td>
        <td>
        <select name="data_reciever" size="1">
            <option><? echo $MSG_ADM_MAILALL_ALLUSERS; ?>
            <option><? echo $MSG_ADM_MAILALL_OPERATORS; ?>
            <option><? echo $MSG_ADM_MAILALL_COMODERATORS; ?>
        </select>
        </td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_MAILALL_SUBJECT; ?></b></td>
        <td><input type="text" name="data_subject" value="<? echo $data_subject; ?>" maxlength="50" size="60"></td>
    </tr>

    <tr>
        <td valign="top"><b> <? echo $MSG_ADM_MAILALL_BODY; ?></b></td>
        <td><textarea name="data_body" rows="15" cols="58"><? echo $data_body; ?></textarea></td>
    </tr>

    </table>

    <br>
    <input type ="hidden" name="action" value="send">
    <input type="submit" name="submit" value=" <? echo $MSG_ADM_MAILALL_SEND; ?>">
    <input type="reset" value="<? echo $MSG_ADM_MAILALL_REFRESH; ?>">

    </form>

</body>
</html>