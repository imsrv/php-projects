<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
    <title> <? echo $MSG_ADM_PAGETITLE; ?></title>
</head>

<body bgcolor="white">

    <br>
    <div align="right">
    <font size="+1"> <? echo "$MSG_ADM_MAILALL - $MSG_ADM_MAILALL_SHOW"; ?></font></div>
    <hr><br>

    <a href="<? echo $PHP_SELF; ?>"><? echo $MSG_ADM_MAILALL_BACK;  ?></a><br><br>

    <table border="1">

    <tr>
        <td><b> <? echo $MSG_ADM_MAILALL_DATE; ?></b></td>
        <td><? echo $data_date; ?></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_MAILALL_RECIEVER; ?></b></td>
        <td><? echo $data_reciever; ?></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_MAILALL_SUBJECT; ?></b></td>
        <td><? echo $data_subject; ?></td>
    </tr>

    <tr>
        <td valign="top"><b> <? echo $MSG_ADM_MAILALL_BODY; ?></b></td>
        <td><? echo $data_body; ?></td>
    </tr>


    </table>

</body>
</html>