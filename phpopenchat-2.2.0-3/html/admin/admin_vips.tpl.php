<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
    <title> <? echo $MSG_ADM_PAGETITLE; ?></title>
</head>

<body bgcolor="white">

    <br>
    <div align="right">
    <font size="+1"> <? echo $MSG_ADM_VIPS; ?></font></div>
    <hr><br>

    <a href="<? echo $PHP_SELF; ?>?action=create"><? echo $MSG_ADM_VIPS_CREATE;  ?></a><br><br>

    <table border="1">

    <!-- table header -->
    <tr>
        <td> <? echo $MSG_ADM_VIPS_NICK; ?> </td>
        <td> <? echo $MSG_ADM_VIPS_MODERATOR; ?> </td>
        <td> <? echo $MSG_ADM_VIPS_CHANNEL; ?> </td>
        <td> <? echo $MSG_ADM_VIPS_DELETE; ?></td>
    </tr>

    <!-- table data -->

    <? for ($index = 0; $index < count($ar_vip_nick); $index++) { ?>

    <tr>
        <td><b><? echo $ar_vip_nick[$index]; ?></b></td>
        <td><b><? echo $ar_vip_moderator[$index]; ?></b></td>
        <td><b><? echo $ar_vip_channel[$index]; ?></b></td>

        <td>
            <a href="<? echo $PHP_SELF; ?>?action=delete&data_nick=<? echo $ar_vip_nick[$index]; ?>">
            <? echo $MSG_ADM_VIPS_DELETE; ?></a>
        </td>
    </tr>

    <? } ?>

    </table>

</body>
</html>