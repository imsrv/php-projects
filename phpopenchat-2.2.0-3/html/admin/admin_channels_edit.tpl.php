<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
    <title> <? echo $MSG_ADM_PAGETITLE; ?></title>
</head>

<body bgcolor="white">

    <br>
    <div align="right">
    <font size="+1"> <? echo "$MSG_ADM_CHANNELS - $MSG_ADM_EDITCHANNEL"; ?></font></div>
    <hr><br>

    <? if ($err_message != "") { ?>
        <br>
        <font color="red">
        <b> <? echo $err_message; ?> </b>
        </font>
        <br><br><br>
    <? } ?>

    <form name="edit_cannels" action="<? echo "admin_channels.$FILE_EXTENSION"; ?>">

    <table border="1">

    <tr>
        <td><b> <? echo $MSG_ADM_CHANNELS_FIELDS['Name']; ?></b></td>
        <td><input type="text" name="data_Name" value="<? echo $data_Name; ?>" size="50"></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_CHANNELS_FIELDS['PASSWORD']; ?></b></td>
        <td><input type="text" name="data_PASSWORD" value="<? echo $data_PASSWORD; ?>" size="50"></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_CHANNELS_FIELDS['These']; ?></b></td>
        <td><input type="text" name="data_These" value="<? echo $data_These; ?>" size="50"></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_CHANNELS_FIELDS['Teilnehmerzahl']; ?></b></td>
        <td><input type="text" name="data_Teilnehmerzahl" value="<? echo $data_Teilnehmerzahl; ?>" size="50"></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_CHANNELS_FIELDS['BG_Color']; ?></b></td>
        <td><input type="text" name="data_BG_Color" value="<? echo $data_BG_Color; ?>" size="50"></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_CHANNELS_FIELDS['NICK_COLOR']; ?></b></td>
        <td><input type="text" name="data_NICK_COLOR" value="<? echo $data_NICK_COLOR; ?>" size="50"></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_CHANNELS_FIELDS['Logo']; ?></b></td>
        <td><input type="text" name="data_Logo" value="<? echo $data_Logo; ?>" size="50"></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_CHANNELS_FIELDS['ExitURL']; ?></b></td>
        <td><input type="text" name="data_ExitURL" value="<? echo $data_ExitURL; ?>" size="50"></td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_CHANNELS_FIELDS['moderiert']; ?></b></td>
        <td>
            <select name="data_moderiert" size="1">
                <? if ($data_moderiert == 0) { ?>
                    <option value="1"> <? echo $YES; ?>
                    <option value="0" selected> <? echo $NO; ?>
                <? } else {?>
                    <option value="1" selected> <? echo $YES; ?>
                    <option value="0" > <? echo $NO; ?>
                <? } ?>
            </select>
        </td>
    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_CHANNELS_FIELDS['starts_at']; ?></b></td>

        <td>

            <!-- start day -->
            <select name="data_startday" size="1">
            <? for ($index=1; $index <= 31; $index++) { ?>
                <? if ($index == $data_startday) { ?>
                    <option selected> <? printf ("%02d", $index); ?>
                <? } else { ?>
                    <option> <? printf ("%02d", $index); ?>
                <? } ?>
            <? } ?>
            </select>

            <!-- start month -->
            <select name="data_startmonth" size="1">
            <? for ($index=1; $index <= 12; $index++) { ?>
                <? if ($index == $data_startmonth) { ?>
                    <option selected> <? printf ("%02d", $index); ?>
                <? } else { ?>
                    <option> <? printf ("%02d", $index); ?>
                <? } ?>
            <? } ?>
            </select>

            <!-- start year -->
            <input type="text" name="data_startyear" value="<? echo $data_startyear; ?>" size="7" maxlength="4">

            <!-- Yes, this "-" is really used. So don't delete it -->
            -

            <!-- start hour -->
            <select name="data_starthour" size="1">
            <? for ($index=0; $index <= 23; $index++) { ?>
                <? if ($index == $data_starthour) { ?>
                    <option selected> <? printf ("%02d", $index); ?>
                <? } else { ?>
                    <option> <? printf ("%02d", $index); ?>
                <? } ?>
            <? } ?>
            </select>

            <!-- start minute -->
            <select name="data_startminute" size="1">
            <? for ($index=0; $index <= 59; $index++) { ?>
                <? if ($index == $data_startminute) { ?>
                    <option selected> <? printf ("%02d", $index); ?>
                <? } else { ?>
                    <option> <? printf ("%02d", $index); ?>
                <? } ?>
            <? } ?>
            </select>

            <!-- start second -->
            <select name="data_startsecond" size="1">
            <? for ($index=0; $index <= 59; $index++) { ?>
                <? if ($index == $data_startsecond) { ?>
                    <option selected> <? printf ("%02d", $index); ?>
                <? } else { ?>
                    <option> <? printf ("%02d", $index); ?>
                <? } ?>
            <? } ?>
            </select>

        </td>

    </tr>

    <tr>
        <td><b> <? echo $MSG_ADM_CHANNELS_FIELDS['stops_at']; ?></b></td>

        <td>

            <!-- stop day -->
            <select name="data_stopday" size="1">
            <? for ($index=1; $index <= 31; $index++) { ?>
                <? if ($index == $stopday) { ?>
                    <option selected> <? printf ("%02d", $index); ?>
                <? } else { ?>
                    <option> <? printf ("%02d", $index); ?>
                <? } ?>
            <? } ?>
            </select>

            <!-- stop month -->
            <select name="data_stopmonth" size="1">
            <? for ($index=1; $index <= 12; $index++) { ?>
                <? if ($index == $data_stopmonth) { ?>
                    <option selected> <? printf ("%02d", $index); ?>
                <? } else { ?>
                    <option> <? printf ("%02d", $index); ?>
                <? } ?>
            <? } ?>
            </select>

            <!-- stop year -->
            <input type="text" name="data_stopyear" value="<? echo $data_stopyear; ?>" size="7" maxlength="4">

            <!-- Yes, this "-" is really used. So don't delete it -->
            -

            <!-- stop hour -->
            <select name="data_stophour" size="1">
            <? for ($index=0; $index <= 23; $index++) { ?>
                <? if ($index == $data_stophour) { ?>
                    <option selected> <? printf ("%02d", $index); ?>
                <? } else { ?>
                    <option> <? printf ("%02d", $index); ?>
                <? } ?>
            <? } ?>
            </select>

            <!-- stop minute -->
            <select name="data_stopminute" size="1">
            <? for ($index=0; $index <= 59; $index++) { ?>
                <? if ($index == $data_stopminute) { ?>
                    <option selected> <? printf ("%02d", $index); ?>
                <? } else { ?>
                    <option> <? printf ("%02d", $index); ?>
                <? } ?>
            <? } ?>
            </select>

            <!-- stop second -->
            <select name="data_stopsecond" size="1">
            <? for ($index=0; $index <= 59; $index++) { ?>
                <? if ($index == $data_stopsecond) { ?>
                    <option selected> <? printf ("%02d", $index); ?>
                <? } else { ?>
                    <option> <? printf ("%02d", $index); ?>
                <? } ?>
            <? } ?>
            </select>

        </td>

    </tr>

    </table>

    <br>
    <input type ="hidden" name="action" value="save">
    <input type ="hidden" name="from_module" value="edit">
    <input type ="hidden" name="ID" value="<? echo $ID; ?>">
    <input type="submit" name="submit" value=" <? echo $MSG_ADM_SAVE; ?>">

    </form>

</body>
</html>