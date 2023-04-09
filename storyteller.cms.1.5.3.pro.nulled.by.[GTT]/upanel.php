<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    require("core.php");

    if (file_exists("bbwrapper.php"))
    {
        header("Location: $bb_panel");
        exit;
    }

    if (phpversion() >= "4.1.0")
    {
        $lcookie = $_COOKIE["esselbachst"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $aform = $_POST["aform"];
        $password1 = $_POST["password1"];
        $password2 = $_POST["password2"];
        $email = $_POST["email"];
        $homepage = $_POST["homepage"];
        $icq = $_POST["icq"];
        $aim = $_POST["aim"];
        $yam = $_POST["yam"];
        $ms = $_POST["ms"];
        $jabber = $_POST["jabber"];
        $location = $_POST["location"];
        $occupation = $_POST["occupation"];
        $interests = $_POST["interests"];
        $picture = $_POST["picture"];
        $cconfig = $_POST["cconfig"];
        $signature = $_POST["signature"];
    }
    else
    {
        $lcookie = $esselbachst;
    }

    $lcookie = checkvar($lcookie);
    $username = checkvar($username);
    $password = checkvar($password);
    $aform = checkvar($aform);
    $password1 = checkvar($password1);
    $password2 = checkvar($password2);
    $email = checkvar($email);
    $homepage = checkvar($homepage);
    $icq = checkvar($icq);
    $aim = checkvar($aim);
    $yam = checkvar($yam);
    $ms = checkvar($ms);
    $jabber = checkvar($jabber);
    $location = checkvar($location);
    $occupation = checkvar($occupation);
    $interests = checkvar($interests);
    $picture = checkvar($picture);
    $cconfig = checkvar($cconfig);
    $signature = checkvar($signature);
    $website = $configs[4];

    HeaderBlock();

    if ($password)
    {
        $ppassword = $password;
        $password = CryptMe($password);
    }

    if (!$username)
    {
        $ldata = base64_decode($lcookie);
        $ldata = explode (":!:", $ldata);
        $username = $ldata[0];
        $password = $ldata[1];
    }

    if ($username)
    {
        dbconnect();
        $query = DBQuery("SELECT * FROM esselbach_st_users WHERE user_name = '$username' AND user_banned = '0'");
        $insert = mysql_fetch_array($query);

        if ((strlen($insert[user_password]) == 32) and (strlen($password) == 40))
        {
            $password = md5($ppassword);
        }

        if ($password == $insert[user_password])
        {
            if ($lcookie)
            {
                if ($ldata[2] != $insert[user_securekey])
                {
                    setcookie ("esselbachst", 0);
                }
            }

            if (!$aform)
            {
                echo GetTemplate("upanel_profile");
            }

            if ($aform == "updprofile")
            {
                $userrtmax = time() - 3600;
                DBQuery("DELETE FROM esselbach_st_userqueue WHERE userq_regtime < $userrtmax");

                DBQuery("UPDATE esselbach_st_users SET user_homepage='$homepage', user_icq='$icq', user_aim='$aim', user_yam='$yam',
                    user_ms='$ms', user_jabber='$jabber', user_location='$location', user_picture='$picture', user_interests='$interests',
                    user_occupation='$occupation', user_signature='$signature', user_cconfig='$cconfig' WHERE user_id='$insert[user_id]'");

                if (($password1) and ($password1 == $password2))
                {
                    $password1 = CryptMe($password1);
                    DBQuery("UPDATE esselbach_st_users SET user_password='$password1' WHERE user_id='$insert[user_id]'");
                }

                if ($email != $insert[user_email])
                {
                    if (eregi("^[_a-z0-9-]+(\\.[_a-z0-9-]+)*@[a-z0-9-]+(\\.[a-z0-9-]+)*(\\.[a-z]{2,4})$", trim($email)))
                    {
                        $ipaddr = GetIP();
                        $regkey = md5(rand(1, 32768)).md5(rand(1, 32768));
                        $userrtime = time();
                        DBQuery("INSERT INTO esselbach_st_userqueue VALUES ('$insert[user_name]', '$insert[user_password]', '$userrtime', '', '$email', '$regkey', '$ipaddr', '1')");

                        $result = DBQuery("SELECT * FROM esselbach_st_users WHERE user_id = '1'");
                        $admin = mysql_fetch_array($result);

                        $insert[site_name] = $sitename;
                        $insert[user_name] = $username;
                        $insert[admin_name] = $admin[user_name];
                        $insert[ipaddr] = $ipaddr;
                        $insert[email] = $email;
                        $insert[activate_url] = "$configs[6]/activate.php?id=$regkey";

                        $message = GetTemplate("mail_update_message");
                        $subject = GetTemplate("mail_update_title");
                        $headers = MailHeader("$admin[user_name]","$admin[user_email]","$insert[user_name]","$email");

                        mail($email, $subject, $message, $headers);

                    }
                }

                echo GetTemplate("upanel_pfupdated");

            }

        }
    }
    else
    {

        echo GetTemplate("upanel_error_notlogged");
    }

    FooterBlock();

?>
