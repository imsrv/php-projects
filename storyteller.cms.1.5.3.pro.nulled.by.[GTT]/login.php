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
        $lusername = $_POST["lusername"];
        $lpassword = $_POST["lpassword"];
    }
    else
    {
        $lcookie = $esselbachst;
    }

    $lcookie = checkvar($lcookie);
    $lusername = checkvar($lusername);
    $lpassword = checkvar($lpassword);
    $website = $configs[4];

    if ((!$lusername) and ($lcookie))
    {
        $ldata = base64_decode($lcookie);
        $ldata = explode (":!:", $ldata);
    }

    if (($lusername) or ($ldata[0]))
    {
        if (!file_exists("bbwrapper.php"))
        {
            dbconnect();
            $query = DBQuery("SELECT * FROM esselbach_st_users WHERE user_banned = '0' AND user_name = '$lusername' OR user_banned = '0' AND user_name = '$ldata[0]'");
            $uexist = mysql_num_rows($query);
            if (!$uexist)
            {
                HeaderBlock();
                echo GetTemplate("login_error");
                FooterBlock();
            }
            $userd = mysql_fetch_array($query);

            if ($ldata)
            {
                if (($ldata[2] != $userd[user_securekey]) or ($ldata[1] != $userd[user_password]))
                {
                    setcookie ("esselbachst", 0);
                    HeaderBlock();
                    echo GetTemplate("login_error");
                }
                else
                {
                    HeaderBlock();
                    echo GetTemplate("login_already");
                }
            }

            if (strlen($userd[user_password]) == 40)
            {
                $lpassword = CryptMe($lpassword);
            }
            else
            {
                $lpassword = md5($lpassword);
            }

            if (($lpassword == $userd[user_password]) and (!$ldata))
            {
                $lsecurekey = CryptMe(rand(1, 32768));
                setcookie ("esselbachst", base64_encode("$lusername:!:$lpassword:!:$lsecurekey"), time()+5184000);
                DBQuery("UPDATE esselbach_st_users SET user_securekey = '$lsecurekey' WHERE user_name = '$lusername'");
                HeaderBlock();
                echo GetTemplate("login_done");
            }
            else
            {
                HeaderBlock();
                echo GetTemplate("login_error");
            }
        }
        else
        {
            if ($ldata)
            {
                if (!BBGetUser($ldata[0], $ldata[1]))
                {
                    setcookie ("esselbachst", 0);
                    BBCookieFlush();
                    HeaderBlock();
                    echo GetTemplate("login_error");
                }
                else
                {
                    HeaderBlock();
                    echo GetTemplate("login_already");
                }
            }

            if (!$ldata)
            {
                if (BBGetUser($lusername, md5($lpassword)))
                {
                    BBCookieInit($lusername, md5($lpassword));
                    $lpassword = md5("$lpassword");
                    $lsecurekey = CryptMe(rand(1, 32768));
                    setcookie ("esselbachst", base64_encode("$lusername:!:$lpassword:!:$lsecurekey"), time()+5184000);
                    HeaderBlock();
                    echo GetTemplate("login_done");
                }
                else
                {
                    HeaderBlock();
                    echo GetTemplate("login_error");
                }
            }
        }

    }
    else
    {
        HeaderBlock();
        echo GetTemplate("login_dologin");
    }

    FooterBlock();

?>
