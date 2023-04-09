<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */
    require("core.php");

    if (phpversion() >= "4.1.0")
    {
        $lcookie = $_COOKIE["esselbachst"];
        $aform = $_POST["aform"];
    }
    else
    {
        $lcookie = $esselbachst;
    }

    $lcookie = checkvar($lcookie);
    $aform = checkvar($aform);
    $website = $configs[4];
    $ipaddr = GetIP();

    HeaderBlock();

    if ($lcookie)
    {
        $ldata = base64_decode($lcookie);
        $ldata = explode (":!:", $ldata);

        if (!file_exists("bbwrapper.php"))
        {
            dbconnect();

            $query = DBQuery("SELECT * FROM esselbach_st_users WHERE user_name = '$ldata[0]' AND user_banned = '0'");
            $userd = mysql_fetch_array($query);
        }
    }

    if (!file_exists("bbwrapper.php"))
    {
        if (($ldata[1] != $userd[user_password]) or (!$lcookie))
        {
            echo GetTemplate("list_error_notlogged");
            FooterBlock();
            exit;
        }
        else
        {
            $useremail = $userd[user_email];
        }

    }
    else
    {
        if ((!BBGetUser($ldata[0], $ldata[1])) or (!$lcookie))
        {
            echo GetTemplate("list_error_notlogged");
            FooterBlock();
            exit;
        }
        else
        {
            $useremail = BBGetEmail($ldata[0]);
        }
        dbconnect();
    }

    if (!$aform)
    {
        $query = DBQuery("SELECT * FROM esselbach_st_mails WHERE mail_email = '$useremail'");
        $check = mysql_num_rows($query);

        if ($check)
        {
            $insert[list_status] = GetTemplate("list_status_subscriber");
        }
        else
        {
        $insert[list_status] = GetTemplate("list_status_none");
        }

        echo GetTemplate("list_settings");
    }

    if ($aform == "subchange")
    {
        $query = DBQuery("SELECT * FROM esselbach_st_mails WHERE mail_email = '$useremail'");
        $check = mysql_num_rows($query);

        if ($check)
        {
            DBQuery("DELETE FROM esselbach_st_mails WHERE mail_email = '$useremail'");
            echo GetTemplate("list_removed");
        }
        else
        {
            DBQuery("INSERT INTO esselbach_st_mails VALUES (NULL, '$ldata[0]', '$website', '$ldata[0]', '$useremail', '$ipaddr', '$ipaddr')");
            echo GetTemplate("list_added");
        }

    }

    FooterBlock();

?>
