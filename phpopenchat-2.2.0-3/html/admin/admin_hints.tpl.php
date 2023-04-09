<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
<html>
<head>
    <title> <? echo $MSG_ADM_PAGETITLE; ?></title>
</head>

<body bgcolor="white">

    <br>
    <div align="right">
    <font size="+1"> <? echo $MSG_ADM_HINTS; ?></font></div>
    <hr><br>

    <form name="hints" action="<? echo "admin_hints.$FILE_EXTENSION"; ?>">

        <b><? echo "$MSG_ADM_HINT 01"; ?></b>
        <input type="text" name="data_Message_0" value="<? echo $data_Message[0]; ?>" size="50"><br>

        <b><? echo "$MSG_ADM_HINT 02"; ?></b>
        <input type="text" name="data_Message_1" value="<? echo $data_Message[1] ?>" size="50"><br>

        <b><? echo "$MSG_ADM_HINT 03"; ?></b>
        <input type="text" name="data_Message_2" value="<? echo $data_Message[2]; ?>" size="50"><br>

        <b><? echo "$MSG_ADM_HINT 04"; ?></b>
        <input type="text" name="data_Message_3" value="<? echo $data_Message[3]; ?>" size="50"><br>

        <b><? echo "$MSG_ADM_HINT 05"; ?></b>
        <input type="text" name="data_Message_4" value="<? echo $data_Message[4]; ?>" size="50"><br>

        <b><? echo "$MSG_ADM_HINT 06"; ?></b>
        <input type="text" name="data_Message_5" value="<? echo $data_Message[5]; ?>" size="50"><br>

        <b><? echo "$MSG_ADM_HINT 07"; ?></b>
        <input type="text" name="data_Message_6" value="<? echo $data_Message[6]; ?>" size="50"><br>

        <b><? echo "$MSG_ADM_HINT 08"; ?></b>
        <input type="text" name="data_Message_7" value="<? echo $data_Message[7]; ?>" size="50"><br>

        <b><? echo "$MSG_ADM_HINT 09"; ?></b>
        <input type="text" name="data_Message_8" value="<? echo $data_Message[8]; ?>" size="50"><br>

        <b><? echo "$MSG_ADM_HINT 10"; ?></b>
        <input type="text" name="data_Message_9" value="<? echo $data_Message[9]; ?>" size="50"><br>

        <input type="hidden" name="action" value="save">

        <br>
        <input type="submit" name="submit" value=" <? echo $MSG_ADM_HINTS_SAVE; ?> ">

    </form>

</body>
</html>