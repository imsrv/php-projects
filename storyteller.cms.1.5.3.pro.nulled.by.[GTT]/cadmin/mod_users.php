<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminAddUser()
    {

        global $words;

        dbconnect();

        MkHeader("_self");
        MkTabHeader ("$words[UA]");

        echo "<table><form action=\"index.php\" method=\"post\">";

        MkOption ("$words[UN]", "", "extra1", "");
        MkOption ("$words[PW]", "", "extra2", "");
        MkOption ("$words[EML]", "", "extra3", "");
        MkOption ("$words[BRD]", "", "extra4", "");
        MkSelect ("$words[AUS]", "extra5", "0");

        echo "<input type=\"hidden\" name=\"aform\" value=\"doadduser\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SUB]\"></font></td></tr></table>";

        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function AdminEditUser($opts)
    {

        global $words;

        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deleteuser")
        {

            if ($options[1] == 1)
            {
                MkHeader("_self");
                MkTabHeader ("$words[DO]");
                echo "$words[AMA]";
                MkTabFooter();
                MkFooter();
            }

            $result = DBQuery("DELETE FROM esselbach_st_users WHERE user_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[UCR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "edituser")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_users WHERE user_id='$options[1]'");
            $users = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EUS] $users[user_name] - $options[1]");

            echo "<table><form action=\"index.php\" method=\"post\">";

            MkOption ("$words[UN]", "", "extra1", "$users[user_name]");
            MkOption ("$words[PW]", "", "extra2", "");
            MkOption ("$words[EML]", "", "extra3", "$users[user_email]");
            MkOption ("$words[JAB]", "", "extra10", "$users[user_jabber]");
            MkOption ("$words[LOT]", "", "extra11", "$users[user_location]");
            MkOption ("$words[OCC]", "", "extra12", "$users[user_occupation]");
            MkOption ("$words[INR]", "", "extra13", "$users[user_interests]");
            MkOption ("$words[PIC]", "$words[UWH]", "extra14", "$users[user_picture]");
            MkArea ("$words[SIG]", "extra15", "$users[user_signature]");
            MkOption ("$words[ICQ]", "", "extra6", "$users[user_icq]");
            MkOption ("$words[AIM]", "", "extra7", "$users[user_aim]");
            MkOption ("$words[YAM]", "", "extra8", "$users[user_yam]");
            MkOption ("$words[MSN]", "", "extra9", "$users[user_ms]");
            MkArea ("$words[CCF]", "extra16", "$users[user_cconfig]");
            MkSelect ("$words[UBA]", "extra17", "$users[user_banned]");
            MkOption ("$words[BRE]", "", "extra18", "$users[user_bannedreason]");
            MkSelect ("$words[AUS]", "extra5", "$users[user_admin]");

            echo "<tr><td> </td></tr> <input type=\"hidden\" name=\"aform\" value=\"doedituser\"><input type=\"hidden\" name=\"zid\" value=\"$users[user_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[EDU]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input type=\"hidden\" name=\"aform\" value=\"searchusers\"><input name=\"zid\" size=\"32\"><input type=\"submit\" value=\"$words[SUB]\"></form>";
        MkTabFooter();

        TblHeader("$words[EID]", "$words[UEM]");

        $result = DBQuery("SELECT user_id, user_name, user_email FROM esselbach_st_users ORDER BY user_id DESC LIMIT 100");

        while (list($user_id, $user_name, $user_email) = mysql_fetch_row($result))
        {
            TblMiddle("$user_id", "$user_name ($user_email)", "edituser&opts=edituser-$user_id", "edituser&opts=deleteuser-$user_id");
        }

        MkFooter();

    }

    //  ##########################################################

    function AdminUserQueue($opts)
    {

        global $words;

        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deleteuser")
        {

            if ($options[1] == 1)
            {
                MkHeader("_self");
                MkTabHeader ("$words[DO]");
                echo "$words[AMA]";
                MkTabFooter();
                MkFooter();
            }

            $result = DBQuery("DELETE FROM esselbach_st_userqueue WHERE userq_regtime='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[UCR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "edituser")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_userqueue WHERE userq_regtime='$options[1]'");
            $users = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EUS] $options[1]");

            echo "<table><form action=\"index.php\" method=\"post\">";

            MkOption ("$words[UN]", "", "extra1", "$users[userq_name]");
            MkOption ("$words[PW]", "", "extra2", "");
            MkOption ("$words[EML]", "", "extra3", "$users[userq_email]");

            echo "<tr><td> </td></tr> <input type=\"hidden\" name=\"aform\" value=\"doeditquser\"><input type=\"hidden\" name=\"zid\" value=\"$users[userq_regtime]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();
        }

        MkHeader("_self");
        MkTabHeader("$words[EDU]");
        echo "$words[EUSQ]";
        MkTabFooter();

        TblHeader("$words[EID]", "$words[UEM]");

        $result = DBQuery("SELECT userq_regtime, userq_name, userq_email FROM esselbach_st_userqueue WHERE userq_update = '0' ORDER BY userq_regtime DESC");

        while (list($user_rt, $user_name, $user_email) = mysql_fetch_row($result))
        {
            TblMiddle("$user_rt", "$user_name ($user_email)", "edituserq&opts=edituser-$user_rt", "edituserq&opts=deleteuser-$user_rt");
        }

        MkFooter();

    }

    //  ##########################################################

    function SearchUsers ()
    {

        global $words, $zid;

        MkHeader("_self");
        MkTabHeader("$words[EDU]");
        echo "<form action=\"index.php\" method=\"post\"><font size=\"2\" face=\"Verdana, Arial\">$words[SRC]</font>";
        echo "<input name=\"zid\" size=\"32\" value=\"$zid\"><input type=\"submit\" value=\"$words[SUB]\"><input type=\"hidden\" name=\"aform\" value=\"searchusers\"></form>";
        MkTabFooter();

        TblHeader("$words[EID]", "$words[USW] $zid");

        $result = DBQuery("SELECT user_id, user_name, user_email FROM esselbach_st_users WHERE (user_name like '%$zid%') ORDER BY user_id DESC LIMIT 100");

        while (list($user_id, $user_name, $user_email) = mysql_fetch_row($result))
        {
            TblMiddle("$user_id", "$user_name ($user_email)", "edituser&opts=edituser-$user_id", "edituser&opts=deleteuser-$user_id");
        }

        MkFooter();

    }

    //  ##########################################################

    function EditUsers ()
    {

        global $words, $zid, $admin, $extra2, $extra1, $extra3, $extra11, $extra12, $extra13, $extra14, $extra15, $extra6, $extra7, $extra8, $extra9, $extra10, $extra16, $extra17, $extra18, $extra5, $ipaddr;

        if (($zid == 1) and ($admin[user_id] != 1))
        {
            MkHeader("_self");
            MkTabHeader ("$words[ERR]");
            echo $words[MA];
            MkTabFooter();
            MkFooter();

        }

        if ($extra2)
        {
            $extra2 = CryptMe($extra2);
            DBQuery("UPDATE esselbach_st_users SET user_password = '$extra2' WHERE user_id = '$zid'");
        }

        DBQuery("UPDATE esselbach_st_users SET user_name = '$extra1', user_email = '$extra3', user_location = '$extra11', user_occupation = '$extra12',
            user_interests = '$extra13', user_picture = '$extra14', user_signature = '$extra15', user_icq = '$extra6', user_aim = '$extra7', user_yam = '$extra8', user_ms = '$extra9', user_jabber = '$extra10',
            user_cconfig = '$extra16', user_banned = '$extra17', user_bannedreason = '$extra18', user_admin = '$extra5', user_editadmin = '$admin[user_name]', user_editadminip = '$ipaddr' WHERE user_id='$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[UC];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditQueueUsers ()
    {

        global $words, $extra1, $extra2, $extra3, $zid;

        if ($extra2)
        {
            if (file_exists("../bbwrapper.php"))
            {
                $extra2 = md5($extra2);
            }
            else
            {
                $extra2 = CryptMe($extra2);
            }
            DBQuery("UPDATE esselbach_st_userqueue SET userq_password = '$extra2' WHERE userq_regtime = '$zid'");
        }

        DBQuery("UPDATE esselbach_st_userqueue SET userq_name = '$extra1', userq_email = '$extra3' WHERE userq_regtime='$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[UC];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function AddUser ()
    {

        global $words, $extra1, $extra2, $extra3, $extra4, $extra5, $admin, $ipaddr;

        $birthday = explode(".", $extra4);

        if (($birthday[2] > 2099) or ($birthday[2] < 1890) or ($birthday[1] > 12) or ($birthday[0] > 31))
        {
            MkHeader("_self");
            MkTabHeader ("$words[ERR]");
            echo $words[IB];
            MkTabFooter();
            MkFooter();
        }

        $userbirthday = "$birthday[2]-$birthday[1]-$birthday[0]";
        $extra2 = CryptMe($extra2);

        $query = DBQuery("SELECT * FROM esselbach_st_users WHERE user_name = '$extra1' or user_email = '$extra3'");

        if (mysql_num_rows($query) > 0)
        {
            MkHeader("_self");
            MkTabHeader ("$words[ERR]");
            echo $words[UX];
            MkTabFooter();
            MkFooter();
        }

        DBQuery("INSERT INTO esselbach_st_users VALUES (NULL, '$extra1', '$extra2', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', now(), '0', '$userbirthday', '', '$extra3', '$extra3', '', '', '', '', '', '', '', '', '', '', '', '0', '', '', '$ipaddr', '$ipaddr', '$extra5', '$admin[user_name]', '$ipaddr')");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[UR];
        MkTabFooter();
        MkFooter();

    }

?>
