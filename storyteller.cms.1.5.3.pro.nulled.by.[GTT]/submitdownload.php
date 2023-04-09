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
        $url1 = $_POST["url1"];
        $url2 = $_POST["url2"];
        $url3 = $_POST["url3"];
        $url4 = $_POST["url4"];
        $url5 = $_POST["url5"];
        $url6 = $_POST["url6"];
        $url7 = $_POST["url7"];
        $url8 = $_POST["url8"];
        $email = $_POST["email"];
    }

    $author = checkvar($author);
    $subject = checkvar($subject);
    $story = checkvar($story);
    $url1 = checkvar($url1);
    $url2 = checkvar($url2);
    $url3 = checkvar($url3);
    $url4 = checkvar($url4);
    $url5 = checkvar($url5);
    $url6 = checkvar($url6);
    $url7 = checkvar($url7);
    $url8 = checkvar($url8);
    $email = checkvar($email);

    $ipaddr = GetIP();
    $website = $configs[4];
    HeaderBlock();

    if ((!$author) or (!$subject) or (!$story))
    {
        echo GetTemplate("submit_download");
    }
    else
    {
        dbconnect();

        $query = DBQuery("SELECT website_email2 FROM esselbach_st_websites WHERE website_id = '$website'");
        list ($emailadd) = mysql_fetch_row($query);

        if ($emailadd)
        {
            $insert[email_subject] = $subject;
            $insert[email_message] = $story;
            $insert[email_author] = $author;
            $insert[email_email] = $email;
            $insert[email_url1] = $url1;
            $insert[email_url2] = $url2;
            $insert[email_url3] = $url3;
            $insert[email_url4] = $url4;
            $insert[email_url5] = $url5;
            $insert[email_url6] = $url6;
            $insert[email_url7] = $url7;
            $insert[email_url8] = $url8;

            $message = GetTemplate("mail_notify_dlmessage");
            $esubject = GetTemplate("mail_notify_dltitle");
            $headers = MailHeader("$emailadd","$emailadd","$emailadd","$emailadd");

            mail($emailadd, $esubject, $message, $headers);
        }

        DBQuery("INSERT INTO esselbach_st_downloadqueue VALUES (NULL, '$website', '$author', '$email', '$ipaddr', '$subject', '$story', now(), '$url1', '$url2', '$url3', '$url4', '$url5', '$url6', '$url7', '$url8')");
        echo GetTemplate("submit_download_done");
    }

    FooterBlock();

?>
