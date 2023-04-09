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
    $text = checkvar($text);
    $email = checkvar($email);

    $ipaddr = GetIP();
    $website = $configs[4];

    HeaderBlock();

    if ((!$author) or (!$subject))
    {
        echo GetTemplate("submit_review");
    }
    else
    {
        dbconnect();

        $query = DBQuery("SELECT website_email5 FROM esselbach_st_websites WHERE website_id = '$website'");
        list ($emailadd) = mysql_fetch_row($query);

        if ($emailadd)
        {
            $insert[email_subject] = $subject;
            $insert[email_author] = $author;
                   $insert[email_text] = $text;
                   $insert[email_email] = $email;

            $message = GetTemplate("mail_notify_reviewmessage");
            $esubject = GetTemplate("mail_notify_reviewtitle");
            $headers = MailHeader("$emailadd","$emailadd","$emailadd","$emailadd");

            mail($emailadd, $esubject, $message, $headers);
        }

        DBQuery("INSERT INTO esselbach_st_reviewqueue VALUES (NULL, '$website', '$author', '$email', '$ipaddr', '$subject', '$text', now())");
        echo GetTemplate("submit_review_done");
    }

    FooterBlock();

?>
