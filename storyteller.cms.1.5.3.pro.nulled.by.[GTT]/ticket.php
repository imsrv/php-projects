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
        $id = $_GET["id"];
        $subject = $_POST["subject"];
        $message = $_POST["message"];
        $category = $_POST["category"];
        $priority = $_POST["priority"];
        $tupdate = $_POST["tupdate"];
        $tracking = $_GET["tracking"];
    }
    else
    {
        $lcookie = $esselbachst;
    }

    $id = checknum($id);
    $subject = checkvar($subject);
    $message = checkvar($message);
    $category = checknum($category);
    $priority = checknum($priority);
    $tracking = checkvar($tracking);
    $tupdate = checkvar($tupdate);

    $ipaddr = GetIP();
    $tdate = date ("l dS of F Y h:i:s A", time());
    $website = $configs[4];

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
            echo GetTemplate("ticket_error_notlogged");
            FooterBlock();
            exit;
        }
    }
    else
    {
        if ((!BBGetUser($ldata[0], $ldata[1])) or (!$lcookie))
        {
            echo GetTemplate("ticket_error_notlogged");
            FooterBlock();
            exit;
        }
        dbconnect();
    }

    if (!$id)
    {
        if (!$message)
        {
            if (!$tracking)
            {
                echo GetTemplate("ticket_list_header");

                $query = DBQuery("SELECT * FROM esselbach_st_ticket WHERE ticket_user = '$ldata[0]'");
                while ($insert = mysql_fetch_array($query))
                {
                    if (!$insert[ticket_priority]) $insert[ticket_priority] = GetTemplate("ticket_closed_text");
                        echo GetTemplate("ticket_list");
                }

                echo GetTemplate("ticket_list_footer");
            }
        }
    }

    if ($tracking)
    {
        if (strlen($tracking) == 32)
        {
            $query = DBQuery("SELECT * FROM esselbach_st_ticket WHERE ticket_pass = '$tracking' AND ticket_website = '$website' AND ticket_user = '$ldata[0]'");
            $insert = mysql_fetch_array($query);
            $insert[ticket_text] = DeChomp($insert[ticket_text]);
            if (!$insert[ticket_priority])
            {
                echo GetTemplate("ticket_closed");
            }
            else
            {
                echo GetTemplate("ticket_edit");
            }
        }
    }

    if (($tupdate) and ($message))
    {
        $query = DBQuery("SELECT * FROM esselbach_st_ticket WHERE ticket_pass = '$tupdate' AND ticket_website = '$website' AND ticket_user = '$ldata[0]'");
        $ticketdata = mysql_fetch_array($query);

        if (mysql_num_rows($query))
        {
            $insert[ticket_user] = $ldata[0];
            $insert[ticket_date] = $tdate;
            $insert[ticket_text] = $ticketdata[ticket_text];
            $insert[ticket_msg] = $message;
            $ttext = GetTemplate("ticket_text_update");
            DBQuery("UPDATE esselbach_st_ticket SET ticket_text = '$ttext', ticket_editip = '$ipaddr' WHERE ticket_pass = '$tupdate'");
        }
        echo GetTemplate("ticket_edit_done");
    }

    if (($subject) and ($message))
    {
        if (($priority < 6) or (!$priority))
        {
            $tracking = md5(rand(1, 32768));
            $insert[ticket_user] = $ldata[0];
            $insert[ticket_date] = $tdate;
            $insert[ticket_msg] = $message;
            $ttext = GetTemplate("ticket_text_post");

            $query = DBQuery("SELECT website_email3 FROM esselbach_st_websites WHERE website_id = '$website'");
            list ($emailadd) = mysql_fetch_row($query);

            if ($emailadd)
            {
                $insert[email_subject] = $subject;
                $insert[email_message] = $ttext;
                $insert[email_author] = $ldata[0];
                $insert[email_priority] = $priority;

                $message = GetTemplate("mail_notify_ticketmessage");
                $subject = GetTemplate("mail_notify_tickettitle");

                $headers = MailHeader("$emailadd","$emailadd","$emailadd","$emailadd");

                mail($emailadd, $subject, $message, $headers);
            }

            DBQuery("INSERT INTO esselbach_st_ticket VALUES (NULL, '$website', '$category', '$subject', '$ttext', '$priority', '$tracking', '$ldata[0]', '$ipaddr', '$ipaddr')");
            $insert[ticket_tracking] = $tracking;
            echo GetTemplate("ticket_send");
        }
    }

    if (($id == 1) and (!$message))
    {
        $query = DBQuery("SELECT * FROM esselbach_st_ticketcat");
        $insert[ticket_categories] = "<select size=\"1\" name=\"category\">";
        while ($ticketcat = mysql_fetch_array($query))
        {
            $insert[ticket_categories] .= "<option value=\"$ticketcat[ticketcat_id]\">$ticketcat[ticketcat_name]</option>";
        }
        $insert[ticket_categories] .= "</select>";
        echo GetTemplate("ticket_post");
    }

    FooterBlock();

?>
