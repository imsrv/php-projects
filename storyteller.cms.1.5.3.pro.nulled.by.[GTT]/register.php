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
        $username = $_POST["username"];
        $password1 = $_POST["password1"];
        $password2 = $_POST["password2"];
        $scode = $_POST["scode"];
        $email = $_POST["email"];
        $year13 = $_POST["year13"];
        $birthd = $_POST["birthd"];
        $birthm = $_POST["birthm"];
        $birthy = $_POST["birthy"];
        $readrules = $_POST["readrules"];
        $lcookie = $_COOKIE["esselbachst"];
    }
    else
    {
        $lcookie = $esselbachst;
    }

    $username = checkvar($username);
    $password1 = checkvar($password1);
    $password2 = checkvar($password2);
    $scode = checkvar($scode);
    $email = checkvar($email);
    $year13 = checknum($year13);
    $birthd = checkvar($birthd);
    $birthm = checkvar($birthm);
    $birthy = checkvar($birthy);
    $readrules = checknum($readrules);
    $lcookie = checkvar($lcookie);
    $website = $configs[4];
    HeaderBlock();

    if ($lcookie)
    {
        $ldata = base64_decode($lcookie);
        $ldata = explode (":!:", $ldata);
        dbconnect();
        $query = DBQuery("SELECT * FROM esselbach_st_users WHERE user_name = '$ldata[0]'");
        $userd = mysql_fetch_array($query);
        if ($ldata[1] == $userd[user_password])
        {
            echo GetTemplate("register_error_already");
            FooterBlock();
            exit;
        }
    }

    if (!$username)
    {
        echo GetTemplate("register");
    }
    else
    {

        if ($password1 != $password2)
        {
            echo GetTemplate("register_error_password");
            FooterBlock();
            exit;
        }

        $sout = substr(md5(date("H D").$configs[7]), 4, 5);
        if ($scode != $sout)
        {
            echo GetTemplate("register_error_scode");
            FooterBlock();
            exit;
        }

        if (!eregi("^[_a-z0-9-]+(\\.[_a-z0-9-]+)*@[a-z0-9-]+(\\.[a-z0-9-]+)*(\\.[a-z]{2,4})$", trim($email)))
        {
            echo GetTemplate("register_error_email");
            FooterBlock();
            exit;
        }

        if (($birthm > 12) or ($birthd > 31) or ($birthy < 1890))
        {
            echo GetTemplate("register_error_date");
            FooterBlock();
            exit;
        }

        if ($birthd > 31)
        {
            echo GetTemplate("register_error_date");
            FooterBlock();
            exit;
        }

        if (($birthy > 2110) or ($birthy < 1890))
        {
            echo GetTemplate("register_error_date");
            FooterBlock();
            exit;
        }

        if (!$readrules)
        {
            echo GetTemplate("register_error_tos");
            FooterBlock();
            exit;
        }

        $birthday = mktime (0, 0, 0, $birthm, $birthd, $birthy);
        $dago = time() - 410227200;

        if (($birthday > $dago) or (!$year13))
        {
            echo GetTemplate("register_error_birth");
            FooterBlock();
            exit;
        }

        $userrtime = time();
        $userrtmax = time() - 3600;
        $regkey = md5(rand(1, 32768)).md5(rand(1, 32768));

        if (file_exists("bbwrapper.php"))
        {
            $password = md5($password1);
        }
        else
        {
            $password = CryptMe($password1);
        }

        $ipaddr = GetIP();

        dbconnect();

        DBQuery("DELETE FROM esselbach_st_userqueue WHERE userq_regtime < $userrtmax");

        if (!file_exists("bbwrapper.php"))
        {
            $result = DBQuery("SELECT * FROM esselbach_st_users WHERE user_name = '$username' or user_email = '$email'");
            if (mysql_num_rows($result))
            {
                echo GetTemplate("register_error_already");
                FooterBlock();
                exit;
            }
        }
        else
        {
            $uquery = BBCheckUser($username, $email);
            if ($uquery)
            {
                echo GetTemplate("register_error_already");
                FooterBlock();
                exit;
            }
            dbconnect();
        }

        $semail = explode("@", trim($email));
        $result = DBQuery("SELECT * FROM esselbach_st_banemails WHERE (banemail_email LIKE '%$semail[1]%')");
        if (mysql_num_rows($result))
        {
            echo GetTemplate("register_error_banned");
            FooterBlock();
            exit;
        }

        $ipaddy = explode(".", $ipaddr);
        $ipaddx = $ipaddy[0].".".$ipaddy[1].".".$ipaddy[2];
        $result = DBQuery("SELECT * FROM esselbach_st_banips WHERE (banip_ip LIKE '%$ipaddx%')");
        if (mysql_num_rows($result))
        {
            echo GetTemplate("register_error_banned");
            FooterBlock();
            exit;
        }

        $result = DBQuery("SELECT * FROM esselbach_st_userqueue WHERE userq_email = '$email' or userq_name = '$username'");
        if (!mysql_num_rows($result))
        {
            DBQuery("INSERT INTO esselbach_st_userqueue VALUES ('$username', '$password', '$userrtime', '$birthy-$birthm-$birthd', '$email', '$regkey', '$ipaddr', '0')");
        }
        else
        {
            echo GetTemplate("register_error_alreadyq");
            FooterBlock();
            exit;
        }

        echo GetTemplate("register_done");

        $result = DBQuery("SELECT * FROM esselbach_st_users WHERE user_id = '1'");
        $admin = mysql_fetch_array($result);

        $insert[site_name] = $configs[5];
        $insert[user_name] = $username;
        $insert[admin_name] = $admin[user_name];
        $insert[ipaddr] = $ipaddr;
        $insert[email] = $email;
        $insert[activate_url] = "$configs[6]/activate.php?id=$regkey";

        $message = GetTemplate("mail_register_message");
        $subject = GetTemplate("mail_register_title");
        $headers = MailHeader("$admin[user_name]","$admin[user_email]","$username","$email");

        mail($email, $subject, $message, $headers);
    }

    FooterBlock();

?>
