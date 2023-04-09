<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
    <title> <? echo $MSG_ADM_PAGETITLE; ?></title>
</head>

<body bgcolor="white">

    <br>
    <div align="right">
    <font size="+1"> <? echo "$MSG_ADM_FORUM - $MSG_ADM_FORUM_MESSAGES"; ?></font></div>
    <hr><br>

    <? echo "$MSG_ADM_FORUM_NAME : <b>$topic</b>"; ?>
    <br>
    <? echo "$MSG_ADM_FORUM_MSGRANGE : <b>$msg_start - $msg_stop</b> $MSG_ADM_FORUM_FROM <b>$msg_count</b>"; ?>
    <br><br>

    <?
        if ($msg_count > $msg_limit +1)
        {
            echo "$MSG_ADM_FORUM_NAV : ";
            echo " [ <a href=\"$PHP_SELF?action=messages&topic=$topic&msgnav=first\">$MSG_ADM_FORUM_FIRST</a> ] ";
            echo " [ <a href=\"$PHP_SELF?action=messages&topic=$topic&msgnav=prev\">$MSG_ADM_FORUM_PREV</a> ] ";
            echo " [ <a href=\"$PHP_SELF?action=messages&topic=$topic&msgnav=next\">$MSG_ADM_FORUM_NEXT</a> ] ";
            echo " [ <a href=\"$PHP_SELF?action=messages&topic=$topic&msgnav=last\">$MSG_ADM_FORUM_LAST</a> ] ";
            echo '<br><br>';
        }
    ?>

    <table border="1">

    <!-- table header -->
    <tr bgcolor="#bfbfbf">
        <td><b> <? echo $MSG_ADM_FORUM_MSGCOUNTER; ?> </b></td>
        <td><b> <? echo $MSG_ADM_FORUM_NICK; ?> </b></td>
        <td><b> <? echo $MSG_ADM_FORUM_DATE; ?> </b></td>
        <td><b> <? echo $MSG_ADM_FORUM_COMMENT; ?> </b></td>
        <td><b> <? echo $MSG_ADM_FORUM_EDIT; ?> </b></td>
        <td><b> <? echo $MSG_ADM_FORUM_DELETE; ?> </b></td>
    </tr>

    <!-- table data -->

    <? for ($index = 0; $index < count($ar_msg_name); $index++) { ?>

    <tr>
        <td><b><? echo $msg_start + $index; ?></b></td>
        <td><? echo $ar_msg_name[$index]; ?></td>
        <td><? echo $ar_msg_date[$index]; ?></td>
        <td><? echo $ar_msg_comment[$index]; ?></td>

        <td>
            <a href="<? echo $PHP_SELF; ?>?action=editmsg&topic=<? echo $topic; ?>&ID=<? echo $ar_msg_number[$index]; ?>">
            <? echo $MSG_ADM_FORUM_EDIT; ?></a>
        </td>


        <td>
            <a onClick="return confirm('<? echo $MSG_ADM_FORUM_MSG_CONFIRM_DEL; ?>');"
            href="<? echo $PHP_SELF; ?>?action=deletemsg&topic=<? echo $topic; ?>&ID=<? echo $ar_msg_number[$index]; ?>">
            <? echo $MSG_ADM_FORUM_DELETE; ?></a>
        </td>
    </tr>

    <? } ?>

    </table>

    <br>
    <font color="red">
    <? echo $MSG_ADM_FORUM_MSG_DELWARNING; ?>
    </font>

</body>
</html>