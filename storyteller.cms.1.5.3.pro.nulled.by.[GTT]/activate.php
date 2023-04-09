<?php

    /*
    ########################
    # |//////////////////| #
    # NULLED by [GTT] =)   #
    # |\\\\\\\\\\\\\\\\\\| #
    ########################
    */

    require("core.php");

    if (phpversion() >= "4.1.0") $id = $_GET["id"];

    $id = checkvar($id);
    $website = $configs[4];

    HeaderBlock();

    if ($id)
    {

        dbconnect();

        $result = DBQuery("SELECT * FROM esselbach_st_userqueue WHERE userq_regkey = '$id'");
        $data = mysql_fetch_array($result);

        if (!mysql_num_rows($result))
        {
            echo GetTemplate("register_error_invalid");
            FooterBlock();
        }

        $ipaddr = GetIP();
        $usrest = DBQuery("SELECT * FROM esselbach_st_users WHERE user_name = '$data[userq_user]'");

        if ($data[userq_update])
        {
            DBQuery("UPDATE esselbach_st_users SET user_email = '$data[userq_email]' WHERE user_name = '$data[userq_name]'");
            DBQuery("DELETE FROM esselbach_st_userqueue WHERE userq_name = '$data[userq_name]'");
            echo GetTemplate("register_reactived");
        }
        else
        {
            if (!file_exists("bbwrapper.php"))
            {
                DBQuery("INSERT INTO esselbach_st_users VALUES (NULL, '$data[userq_name]', '$data[userq_password]', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', now(),
                    '0', '$data[userq_birthday]', '', '$data[userq_email]', '$data[userq_email]','','','','','','','','','','','','0','','','$ipaddr','$ipaddr','0','','127.0.0.1')");
            }
            else
            {
                BBUserInsert("$data[userq_name]", "$data[userq_password]", "$data[userq_birthday]", "$data[userq_email]", "$ipaddr");
            }
            DBQuery("DELETE FROM esselbach_st_userqueue WHERE userq_name = '$data[userq_name]'");
            echo GetTemplate("register_active");

            $result = DBQuery("SELECT * FROM esselbach_st_users WHERE user_id = '1'");
            $admin = mysql_fetch_array($result);

            $insert[sitename] = $configs[5];
            $insert[username] = $data[userq_name];
            $email = $data[userq_email];

            $message = GetTemplate("mail_activate_message");
            $subject = GetTemplate("mail_activate_title");
            $headers = MailHeader("$admin[user_name]","$admin[user_email]","$data[userq_name]","$data[userq_email]");

            mail($email, $subject, $message, $headers);
        }
    }

    FooterBlock();

?>
