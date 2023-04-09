<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
    <title> <? echo $MSG_ADM_PAGETITLE; ?></title>
</head>

<body bgcolor="white">

    <br>
    <div align="right">
    <font size="+1"> <? echo $MSG_ADM_FORUM; ?></font></div>
    <hr><br>

    <a href="<? echo $PHP_SELF; ?>?action=create"><? echo $MSG_ADM_FORUM_ADDTOPIC;  ?></a><br><br>

    <font color="red">
    <? echo $MSG_ADM_FORUM_DELWARNING; ?>
    </font>
    <br><br>

    <table border="1">

    <!-- table header -->
    <tr>
        <td> <? echo $MSG_ADM_FORUM_NAME; ?> </td>
        <td> <? echo $MSG_ADM_FORUM_MSGCOUNT; ?> </td>
        <td> <? echo $MSG_ADM_FORUM_DELETE; ?></td>
        <td> <? echo $MSG_ADM_FORUM_MESSAGES; ?></td>
    </tr>

    <!-- table data -->

    <? for ($index = 0; $index < count($ar_topic); $index++) { ?>

    <tr>
        <td><b><? echo $ar_topic[$index]; ?></b></td>

        <td align="center"><b><? echo $ar_topic_msgcount[$index]; ?></b></td>

        <td>
            <a onClick="return confirm('<? echo $MSG_ADM_FORUM_CONFIRM_DEL; ?>');"
            href="<? echo $PHP_SELF; ?>?action=delete&topic=<? echo $ar_topic[$index]; ?>">
            <? echo $MSG_ADM_DELETECHANNEL; ?></a>
        </td>

        <td>
            <a href="<? echo $PHP_SELF; ?>?action=messages&topic=<? echo $ar_topic[$index]; ?>">
            <? echo $MSG_ADM_FORUM_MESSAGES; ?></a>
        </td>

    </tr>

    <? } ?>

    </table>

</body>
</html>