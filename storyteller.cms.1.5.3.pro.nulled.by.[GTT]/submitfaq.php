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
        $email = $_POST["email"];
    }

    $author = checkvar($author);
    $subject = checkvar($subject);
    $email = checkvar($email);

    $ipaddr = GetIP();
    $website = $configs[4];

    HeaderBlock();

    if ((!$author) or (!$subject))
    {
        echo GetTemplate("submit_faq");
    }
    else
    {
        dbconnect();

        $query = DBQuery("SELECT website_email4 FROM esselbach_st_websites WHERE website_id = '$website'");
        list ($emailadd) = mysql_fetch_row($query);

        if ($emailadd)
        {
            $insert[email_subject] = $subject;
            $insert[email_author] = $author;
            $insert[email_email] = $email;

            $message = GetTemplate("mail_notify_faqmessage");
            $esubject = GetTemplate("mail_notify_faqtitle");
            $headers = MailHeader("$emailadd","$emailadd","$emailadd","$emailadd");

            mail($emailadd, $esubject, $message, $headers);
        }

        DBQuery("INSERT INTO esselbach_st_faqqueue VALUES (NULL, '$website', '$author', '$email', '$ipaddr', '$subject', now())");
        echo GetTemplate("submit_faq_done");
    }

    FooterBlock();

?>
