<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
    <title> <? echo $MSG_ADM_PAGETITLE; ?></title>
</head>

<body bgcolor="white">

    <br>
    <div align="right">
    <font size="+1"> <? echo "$MSG_ADM_VIPS - $MSG_ADM_VIPS_CREATE"; ?></font></div>
    <hr><br>

    <? if ($err_message != "") { ?>
        <br>
        <font color="red">
        <b> <? echo $err_message; ?> </b>
        </font>
        <br><br><br>
    <? } ?>

    <form name="create_vip" action="<? echo "admin_vips.$FILE_EXTENSION"; ?>">

    <table border="1">

    <tr>
        <td><b> <? echo $MSG_ADM_VIPS_NICK; ?></b></td>
        <td><input type="text" name="data_nick" value="<? echo $data_nick; ?>" size="40"></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_VIPS_MODERATOR; ?></b></td>
        <td><input type="text" name="data_moderator" value="<? echo $data_moderator; ?>" size="40"></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_VIPS_CHANNEL; ?></b></td>
        <td>

            <!-- Channel selection -->
            <select name="data_channel" size="1">
            <?
                for ($index=0; $index < count($ar_vip_channellist); $index++)
                {
                    if ($ar_vip_channellist[$index] == $data_channel)
                    {
                        echo "<option selected>$ar_vip_channellist[$index]";
                    }
                    else
                    {
                        echo "<option>$ar_vip_channellist[$index]";
                    }
                }
            ?>
            </select>
        </td>

    </tr>

    </table>

    <br>
    <input type ="hidden" name="action" value="save">
    <input type ="hidden" name="from_module" value="create">
    <input type="submit" name="submit" value=" <? echo $MSG_ADM_SAVE; ?>">

    </form>

</body>
</html>