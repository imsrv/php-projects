<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
    <title> <? echo $MSG_ADM_PAGETITLE; ?></title>
</head>

<body bgcolor="white">

    <br>
    <div align="right">
    <font size="+1"> <? echo $MSG_ADM_CHANNELS; ?></font></div>
    <hr><br>

    <a href="<? echo $PHP_SELF; ?>?action=create"><? echo $MSG_ADM_NEWCHANNEL;  ?></a><br><br>

    <table border="1">

    <!-- table header -->
    <tr>
        <td> <? echo $MSG_ADM_CHANNELNAME; ?> </td>
        <td> <? echo $MSG_ADM_EDITCHANNEL; ?>    </td>
        <td> <? echo $MSG_ADM_DELETECHANNEL; ?></td>
        <td> <? echo $MSG_ADM_CLEAR_LINES; ?></td>
    </tr>

    <!-- table data -->

    <? for ($index = 0; $index < count($ar_channelname); $index++) { ?>

    <tr>
        <td><b><? echo $ar_channelname[$index]; ?></b></td>

        <td>
            <a href="<? echo $PHP_SELF; ?>?action=edit&ID=<? echo $ar_channelID[$index]; ?>">
            <? echo $MSG_ADM_EDITCHANNEL; ?></a>
        </td>

        <td>
            <a onClick="return confirm('<? echo $MSG_ADM_CHANNELS_CONFIRM_DEL; ?>');"
            href="<? echo $PHP_SELF; ?>?action=delete&ID=<? echo $ar_channelID[$index]; ?>">
            <? echo $MSG_ADM_DELETECHANNEL; ?></a>
        </td>

        <td>
            <a href="<? echo $PHP_SELF; ?>?action=clean&ID=<? echo $ar_channelID[$index]; ?>">
            <? echo $MSG_ADM_CLEAR_LINES; ?></a>
        </td>

    </tr>

    <? } ?>

    </table>

</body>
</html>