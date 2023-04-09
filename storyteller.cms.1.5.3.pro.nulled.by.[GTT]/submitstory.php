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
        $story = $_POST["story"];
        $email = $_POST["email"];
    }

    $author = checkvar($author);
    $subject = checkvar($subject);
    $story = checkvar($story);
    $email = checkvar($email);

    $ipaddr = GetIP();
    $website = $configs[4];

    HeaderBlock();

    if ((!$author) or (!$subject) or (!$story))
    {
        echo GetTemplate("submit_news");
    }
    else
    {
        dbconnect();

        $query = DBQuery("SELECT website_email1 FROM esselbach_st_websites WHERE website_id = '$website'");
        list ($emailadd) = mysql_fetch_row($query);

        if ($emailadd)
        {
            $insert[email_subject] = $subject;
            $insert[email_message] = $story;
            $insert[email_author] = $author;
            $insert[email_email] = $email;

            $message = GetTemplate("mail_notify_newsmessage");
            $esubject = GetTemplate("mail_notify_newstitle");
            $headers = MailHeader("$emailadd","$emailadd","$emailadd","$emailadd");

            mail($emailadd, $esubject, $message, $headers);
        }

        DBQuery("INSERT INTO esselbach_st_storyqueue VALUES (NULL, '$website', '$author', '$email', '$ipaddr', '$subject', '$story', now())");
        echo GetTemplate("submit_news_done");
    }

    FooterBlock();

?>
