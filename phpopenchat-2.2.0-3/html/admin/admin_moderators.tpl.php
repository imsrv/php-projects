<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
    <title> <? echo $MSG_ADM_PAGETITLE; ?></title>
</head>

<body bgcolor="white">

    <br>
    <div align="right">
    <font size="+1"> <? echo $MSG_ADM_MODERATORS; ?></font></div>
    <hr><br>

    <? if ($err_message != "") { ?>
        <br>
        <font color="red">
        <b> <? echo $err_message; ?> </b>
        </font>
        <br><br><br>
    <? } ?>

    <form name="add_moderator" action="<? echo "admin_moderators.$FILE_EXTENSION"; ?>">
        <input type="hidden" name="action" value="add">
        <input type="text" name="data_nick" value="<? echo $data_nick; ?>" size="30">
        <input type="submit" name="submit" value="<? echo $MSG_ADM_NEWMODERATOR; ?>">
    <form>
    <br><br>

    <table border="1">

    <!-- table header -->
    <tr>
        <td> <? echo $MSG_ADM_MODERATORNAME; ?> </td>
        <td> <? echo $MSG_ADM_DELETEMODERATOR; ?></td>
    </tr>

    <!-- table data -->

    <? for ($index = 0; $index < count($ar_moderators); $index++) { ?>

    <tr>
        <td><b><? echo $ar_moderators[$index]; ?></b></td>

        <td>
            <a href="<? echo $PHP_SELF; ?>?action=delete&data_nick=<? echo $ar_moderators[$index]; ?>">
            <? echo $MSG_ADM_DELETEMODERATOR; ?></a>
        </td>
    </tr>

    <? } ?>

    </table>

</body>
</html>