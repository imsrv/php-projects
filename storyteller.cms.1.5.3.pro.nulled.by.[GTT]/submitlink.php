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
        $author = $_POST["author"];
        $subject = $_POST["subject"];
        $text = $_POST["text"];
        $email = $_POST["email"];
    }

    $author = checkvar($author);
    $subject = checkvar($subject);
    $email = checkvar($email);
    $text = checkvar($text);

    $ipaddr = GetIP();
    $website = $configs[4];

    HeaderBlock();

    if ((!$author) or (!$subject) or (!$text))
    {
        echo GetTemplate("submit_link");
    }
    else
    {
        dbconnect();

        $query = DBQuery("SELECT website_email6 FROM esselbach_st_websites WHERE website_id = '$website'");
        list ($emailadd) = mysql_fetch_row($query);

        if ($emailadd)
        {
            $insert[email_subject] = $subject;
            $insert[email_author] = $author;
                   $insert[email_text] = $text;
                   $insert[email_email] = $email;

            $message = GetTemplate("mail_notify_linkmessage");
            $esubject = GetTemplate("mail_notify_linktitle");
            $headers = MailHeader("$emailadd","$emailadd","$emailadd","$emailadd");

            mail($emailadd, $esubject, $message, $headers);
        }

        DBQuery("INSERT INTO esselbach_st_linksqueue VALUES (NULL, '$website', '$author', '$email', '$ipaddr', '$subject', '$text', now())");
        echo GetTemplate("submit_link_done");
    }

    FooterBlock();

?>
