<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
    <title> <? echo $MSG_ADM_PAGETITLE; ?></title>
</head>

<body bgcolor="white">

    <br>
    <div align="right">
    <font size="+1"> <? echo $MSG_ADM_COMODERATORS; ?></font></div>
    <hr><br>

    <? if ($err_message != "") { ?>
        <font color="red">
        <b> <? echo $err_message; ?> </b>
        </font>
        <br><br><br>
    <? } ?>

    <form name="add_comoderator" action="<? echo "admin_comoderators.$FILE_EXTENSION"; ?>">
        <input type="hidden" name="action" value="add">
        <input type="text" name="data_nick" value="<? echo $data_nick; ?>" size="30">
        <input type="submit" name="submit" value="<? echo $MSG_ADM_NEWCOMODERATOR; ?>">
    <form>
    <br>

    <table border="1">

    <!-- table header -->
    <tr>
        <td> <? echo $MSG_ADM_COMODERATORNAME; ?> </td>
        <td> <? echo $MSG_ADM_DELETECOMODERATOR; ?></td>
    </tr>

    <!-- table data -->

    <? for ($index = 0; $index < count($ar_comoderators); $index++) { ?>

    <tr>
        <td><b><? echo $ar_comoderators[$index]; ?></b></td>

        <td>
            <a href="<? echo $PHP_SELF; ?>?action=delete&data_nick=<? echo $ar_comoderators[$index]; ?>">
            <? echo $MSG_ADM_DELETECOMODERATOR; ?></a>
        </td>
    </tr>

    <? } ?>

    </table>

</body>
</html>