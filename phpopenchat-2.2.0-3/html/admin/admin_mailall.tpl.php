<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
    <title> <? echo $MSG_ADM_PAGETITLE; ?></title>
</head>

<body bgcolor="white">

    <br>
    <div align="right">
    <font size="+1"> <? echo $MSG_ADM_MAILALL; ?></font></div>
    <hr><br>

    <a href="<? echo $PHP_SELF; ?>?action=create"><? echo $MSG_ADM_MAILALL_NEWMAIL;  ?></a><br><br>

    <br>
    <b> <? echo $MSG_ADM_MAILALL_OLDMAILS; ?> </b>
    <br><br>

    <table border="1">

    <!-- table header -->
    <tr>
        <td> <? echo $MSG_ADM_MAILALL_SUBJECT; ?> </td>
        <td> <? echo $MSG_ADM_MAILALL_RECIEVER; ?> </td>
        <td> <? echo $MSG_ADM_MAILALL_DATE; ?> </td>
        <td> <? echo $MSG_ADM_MAILALL_SHOW; ?></td>
        <td> <? echo $MSG_ADM_MAILALL_DELETE; ?></td>
    </tr>

    <!-- table data -->

    <? for ($index = 0; $index < count($ar_mailall_subject); $index++) { ?>

    <tr>
        <td><b><? echo $ar_mailall_subject[$index]; ?></b></td>
        <td><b><? echo $ar_mailall_reciever[$index]; ?></b></td>
        <td><b><? echo $ar_mailall_time[$index]; ?></b></td>

        <td>
            <a href="<? echo $PHP_SELF; ?>?action=show&ID=<? echo $ar_mailall_ID[$index]; ?>">
            <? echo $MSG_ADM_MAILALL_SHOW; ?></a>
        </td>


        <td>
            <a onClick="return confirm('<? echo $MSG_ADM_MAILALL_CONFIRM_DEL; ?>');"
            href="<? echo $PHP_SELF; ?>?action=delete&ID=<? echo $ar_mailall_ID[$index]; ?>">
            <? echo $MSG_ADM_MAILALL_DELETE; ?></a>
        </td>

    </tr>

    <? } ?>

    </table>

</body>
</html>