<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
    <title> <? echo $MSG_ADM_PAGETITLE; ?></title>
</head>

<body bgcolor="white">

    <br>
    <div align="right">
    <font size="+1"><? echo "$MSG_ADM_FORUM - $MSG_ADM_FORUM_ADDTOPIC"; ?></font></div>
    <hr><br>

    <? if ($err_message != "") { ?>
        <br>
        <font color="red">
        <b> <? echo $err_message; ?> </b>
        </font>
        <br><br><br>
    <? } ?>

    <form name="create_topic" action="<? echo "admin_forum.$FILE_EXTENSION"; ?>">

    <table border="1">

    <tr>
        <td><b> <? echo $MSG_ADM_FORUM_ADDTOPIC; ?></b></td>
        <td><input type="text" name="data_topic" value="<? echo $data_topic; ?>" size="50"></td>
    </tr>


    <tr>
        <td><b> <? echo $MSG_ADM_FORUM_INITMSG; ?></b></td>
        <td><textarea name="data_initmsg" rows="5" cols="50"><? echo $data_initmsg; ?></textarea></td>
    </tr>

    </table>

    <br>
    <input type ="hidden" name="action" value="save">
    <input type ="hidden" name="from_module" value="create">
    <input type="submit" name="submit" value=" <? echo $MSG_ADM_SAVE; ?>">

    </form>

</body>
</html>