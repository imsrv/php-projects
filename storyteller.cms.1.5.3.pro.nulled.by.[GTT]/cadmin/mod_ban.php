<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    function AdminBanIP($opts)
    {

        global $words;

        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deleteip")
        {

            $result = DBQuery("DELETE FROM esselbach_st_banips WHERE banip_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[ISE]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editip")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_banips WHERE banip_id='$options[1]'");
            $ips = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EIP]");
            echo "<table><form action=\"index.php\" method=\"post\">";
            MkOption ("$words[IPD]", "", "extra1", "$ips[banip_ip]");
            echo "<input type=\"hidden\" name=\"aform\" value=\"editbanip\"><input type=\"hidden\" name=\"zid\" value=\"$ips[banip_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[IBL]");
        echo "$words[IBD]";
        MkTabFooter();

        TblHeader("$words[ID]", "$words[IPD]");

        $result = DBQuery("SELECT banip_id, banip_ip FROM esselbach_st_banips ORDER BY banip_id");

        while (list($ban_id, $ban_ip) = mysql_fetch_row($result))
        {
            TblMiddle("$ban_id", "$ban_ip", "banip&opts=editip-$ban_id", "banip&opts=deleteip-$ban_id");
        }
        TblFooter();

        MkTabHeader("$words[AIP]");
        echo "<table><form action=\"index.php\" method=\"post\">";
        MkOption ("$words[IPD]", "", "extra1", "0.0.0.0");
        echo "<input type=\"hidden\" name=\"aform\" value=\"addbanip\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }

    //  ##########################################################

    function AdminBanWord($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deleteword")
        {

            $result = DBQuery("DELETE FROM esselbach_st_banwords WHERE banword_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[WSR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editword")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_banwords WHERE banword_id='$options[1]'");
            $bwords = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EWO]");
            echo "<table><form action=\"index.php\" method=\"post\">";
            MkOption ("$words[WRD]", "", "extra1", "$bwords[banword_word]");
            echo "<input type=\"hidden\" name=\"aform\" value=\"editbanword\"><input type=\"hidden\" name=\"zid\" value=\"$bwords[banword_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[WBL]");
        echo "$words[WBD]";
        MkTabFooter();

        TblHeader("$words[ID]", "$words[WRD]");

        $result = DBQuery("SELECT banword_id, banword_word FROM esselbach_st_banwords ORDER BY banword_id");

        while (list($ban_id, $ban_word) = mysql_fetch_row($result))
        {
            TblMiddle("$ban_id", "$ban_word", "banword&opts=editword-$ban_id", "banword&opts=deleteword-$ban_id");
        }
        TblFooter();

        MkTabHeader("$words[AWO]");
        echo "<table><form action=\"index.php\" method=\"post\">";
        MkOption ("$words[WRD]", "", "extra1", "");
        echo "<input type=\"hidden\" name=\"aform\" value=\"addbanword\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }

    //  ##########################################################

    function AdminBanEmail($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deleteemail")
        {

            $result = DBQuery("DELETE FROM esselbach_st_banemails WHERE banemail_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$word[ECR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "editemail")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_banemails WHERE banemail_id='$options[1]'");
            $bemails = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EEM]");
            echo "<table><form action=\"index.php\" method=\"post\">";
            MkOption ("$words[EML]", "", "extra1", "$bemails[banemail_email]");
            echo "<input type=\"hidden\" name=\"aform\" value=\"editbanemail\"><input type=\"hidden\" name=\"zid\" value=\"$bemails[banemail_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[EBL]");
        echo "$words[EBD]";
        MkTabFooter();

        TblHeader("$words[ID]", "$words[EML]");

        $result = DBQuery("SELECT banemail_id, banemail_email FROM esselbach_st_banemails ORDER BY banemail_id");

        while (list($ban_id, $ban_email) = mysql_fetch_row($result))
        {
            TblMiddle("$ban_id", "$ban_email", "banemail&opts=editemail-$ban_id", "banemail&opts=deleteemail-$ban_id");
        }
        TblFooter();

        MkTabHeader("$words[AEM]");
        echo "<table><form action=\"index.php\" method=\"post\">";
        MkOption ("$words[EBL]", "", "extra1", "");
        echo "<input type=\"hidden\" name=\"aform\" value=\"addbanemail\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }

    //  ##########################################################

    function AdminBanUser($opts)
    {

        global $words;
        dbconnect();

        $options = explode("-", $opts);
        if ($options[0] == "deleteuser")
        {

            $result = DBQuery("UPDATE esselbach_st_users SET user_banned = '0' AND user_bannedreason = ' ' WHERE user_id='$options[1]'");

            MkHeader("_self");
            MkTabHeader ("$words[DO]");
            echo "$words[UBCR]";
            MkTabFooter();
            MkFooter();

        }

        if ($options[0] == "edituser")
        {

            $result = DBQuery("SELECT * FROM esselbach_st_users WHERE user_id='$options[1]'");
            $busers = mysql_fetch_array($result);

            MkHeader("_self");
            MkTabHeader("$words[EUS]");
            echo "<table><form action=\"index.php\" method=\"post\">";
            MkOption ("$words[BRS]", "", "extra2", "$busers[user_bannedreason]");
            echo "<input type=\"hidden\" name=\"aform\" value=\"editbanuser\"><input type=\"hidden\" name=\"zid\" value=\"$busers[user_id]\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
            MkTabFooter();
            MkFooter();

        }

        MkHeader("_self");
        MkTabHeader("$words[UBL]");
        echo "$words[UBD]";
        MkTabFooter();

        TblHeader("$words[EID]", "$words[RUS]");

        $result = DBQuery("SELECT user_id, user_name, user_bannedreason FROM esselbach_st_users WHERE user_banned = '1' ORDER BY user_id");

        while (list($user_id, $user_name, $user_reason) = mysql_fetch_row($result))
        {
            TblMiddle("$user_id", "$user_name ($user_reason)", "banuser&opts=edituser-$user_id", "banuser&opts=deleteuser-$user_id");
        }
        TblFooter();

        MkTabHeader("$words[AUS]");
        echo "<table><form action=\"index.php\" method=\"post\">";
        MkOption ("$words[US]", "", "extra1", "");
        MkOption ("$words[BRS]", "", "extra2", "");
        echo "<input type=\"hidden\" name=\"aform\" value=\"addbanuser\"><td><font face=\"Arial\" size=\"2\"><input type=\"submit\" value=\"$words[SND]\"></font></td></tr></table>";
        MkTabFooter();

        MkFooter();

    }

    //  ##########################################################

    function AddBanIPs ()
    {

        global $words, $admin, $extra1, $ipaddr;

        DBQuery("INSERT INTO esselbach_st_banips VALUES (NULL, '$admin[user_name]', '$extra1', '$ipaddr', '$ipaddr')");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[BCU];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditBanIPs ()
    {

        global $words, $extra1, $ipaddr, $zid;

        DBQuery("UPDATE esselbach_st_banips SET banip_ip='$extra1', banip_editip='$ipaddr' WHERE banip_id = '$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[BCU];
        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function AddBanWords ()
    {

        global $words, $admin, $extra1, $ipaddr;

        DBQuery("INSERT INTO esselbach_st_banwords VALUES (NULL, '$admin[user_name]', '$extra1', '$ipaddr', '$ipaddr')");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[BCU];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditBanWords ()
    {

        global $words, $extra1, $ipaddr, $zid;

        DBQuery("UPDATE esselbach_st_banwords SET banword_word='$extra1', banword_editip='$ipaddr' WHERE banword_id = '$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[BCU];
        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function AddBanEmail ()
    {

        global $words, $admin, $extra1, $ipaddr;

        DBQuery("INSERT INTO esselbach_st_banemails VALUES (NULL, '$admin[user_name]', '$extra1', '$ipaddr', '$ipaddr')");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[BCU];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditBanEmail ()
    {

        global $words, $extra1, $ipaddr, $zid;

        DBQuery("UPDATE esselbach_st_banemails SET banemail_email='$extra1', banemail_editip='$ipaddr' WHERE banemail_id = '$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[BCU];
        MkTabFooter();
        MkFooter();
    }

    //  ##########################################################

    function AddBanUser ()
    {

        global $words, $admin, $extra1, $ipaddr;

        DBQuery("UPDATE esselbach_st_users SET user_banned = '1', user_bannedreason = '$extra2', user_editadmin = '$admin[user_name]', user_editadminip = '$ipaddr' WHERE user_name = '$extra1'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[BCU];
        MkTabFooter();
        MkFooter();

    }

    //  ##########################################################

    function EditBanUser ()
    {

        global $words, $extra1, $ipaddr, $zid;

        DBQuery("UPDATE esselbach_st_users SET user_bannedreason = '$extra2', user_editadmin = '$admin[user_name]', user_editadminip = '$ipaddr' WHERE user_id = '$zid'");

        MkHeader("_self");
        MkTabHeader ("$words[DO]");
        echo $words[BCU];
        MkTabFooter();
        MkFooter();
    }

?>
