<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    require("core.php");

    (phpversion() >= "4.1.0") ? $lcookie = $_COOKIE["esselbachst"] :
     $lcookie = $esselbachst;

    $lcookie = checkvar($lcookie);

    if ($lcookie)
    {
        $ldata = base64_decode($lcookie);
        $ldata = explode (":!:", $ldata);

        if (!file_exists("bbwrapper.php"))
        {
            dbconnect();
            $query = DBQuery("SELECT * FROM esselbach_st_users WHERE user_name = '$ldata[0]'");
            $userd = mysql_fetch_array($query);

            if ($userd[user_securekey] == $ldata[2])
            {
                DBQuery("UPDATE esselbach_st_users SET user_securekey = '0'");
            }
        }
        else
        {
            BBCookieFlush();
        }
    }

    setcookie ("esselbachst", 0);

    HeaderBlock();

    echo GetTemplate("login_logout_done");

    FooterBlock();

?>
